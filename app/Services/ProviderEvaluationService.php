<?php

namespace App\Services;

use App\Enums\ProviderEvaluationQuestion;
use App\Mail\ProviderEvaluation\EvaluationCreated;
use App\Models\ProviderEvaluation;
use App\Models\ProviderEvaluationResponse;
use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ProviderEvaluationService
{
    /**
     * Creates a provider evaluation for the given order.
     * Only applies to orders linked to a requisition of category 'proveeduria' or 'servicio'.
     */
    public static function createForOrder(PurchaseOrder $order): ?ProviderEvaluation
    {
        $type = $order->requisition?->category;

        if (! in_array($type, ['proveeduria', 'servicio'])) {
            return null;
        }

        $evaluation = ProviderEvaluation::create([
            'purchase_order_id' => $order->id,
            'type' => $type,
            'status' => 'pending',
        ]);

        $respondents = self::resolveRespondents($order);

        foreach (ProviderEvaluationQuestion::forType($type) as $question) {
            $respondentIds = $respondents[$question->role()] ?? [];

            foreach ($respondentIds as $respondentId) {
                $evaluation->responses()->create([
                    'question' => $question->value,
                    'respondent_role' => $question->role(),
                    'respondent_id' => $respondentId,
                    'selected_option' => null,
                    'score' => null,
                    'answered_at' => null,
                ]);
            }
        }

        self::notifyRespondents($evaluation, $order);

        return $evaluation;
    }

    /**
     * Cancels open evaluations for an order when the workflow is restarted.
     *
     * @return int Number of evaluations deleted.
     */
    public static function cancelPendingForOrder(PurchaseOrder $order): int
    {
        return ProviderEvaluation::query()
            ->where('purchase_order_id', $order->id)
            ->where('status', 'pending')
            ->delete();
    }

    /**
     * Sends evaluation-created notification to each unique respondent.
     */
    private static function notifyRespondents(ProviderEvaluation $evaluation, PurchaseOrder $order): void
    {
        $evaluation->load('responses.respondent');

        // Group responses by respondent so each user gets one email
        $byRespondent = $evaluation->responses
            ->whereNotNull('respondent_id')
            ->groupBy('respondent_id');

        $company = $order->company?->name ?? '';
        $folio = $order->folio ?? '';
        $provider = $order->provider?->company_name ?? '';
        $requisitionFolio = $order->requisition?->folio ?? '';
        $purchaser = $order->purchaser?->name ?? '';

        foreach ($byRespondent as $respondentId => $responses) {
            $respondent = $responses->first()->respondent;

            if (! $respondent || ! $respondent->email) {
                continue;
            }

            $role = $responses->first()->respondent_role;

            Mail::to($respondent->email)->queue(new EvaluationCreated([
                'respondent_name' => $respondent->name,
                'respondent_role' => $role,
                'company' => $company,
                'folio' => $folio,
                'provider' => $provider,
                'requisition_folio' => $requisitionFolio,
                'purchaser' => $purchaser,
                'type' => $evaluation->type,
            ]));
        }
    }

    /**
     * Saves a respondent's answer to a single response record.
     * Calculates and stores the score internally (never exposed to the user).
     */
    public static function answer(ProviderEvaluationResponse $response, string $selectedOption): void
    {
        $question = $response->questionEnum();

        $response->update([
            'selected_option' => $selectedOption,
            'score' => $question->scoreForOption($selectedOption),
            'answered_at' => now(),
        ]);

        $response->evaluation->markCompletedIfAllAnswered();
    }

    /**
     * @return array<string, int[]> role => list of user_ids
     */
    private static function resolveRespondents(PurchaseOrder $order): array
    {
        $warehouseUserIds = User::role('revisa_almacen_requisicion_compra')->pluck('id')->all();

        return [
            'solicitante' => array_filter([$order->requisition?->approvalChain?->requester_id]),
            'comprador' => array_filter([$order->purchaser_user_id]),
            'almacen' => $warehouseUserIds,
        ];
    }
}
