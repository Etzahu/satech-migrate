<?php

namespace App\Services;

use App\Enums\ProviderEvaluationQuestion;
use App\Mail\ProviderEvaluation\EvaluationCreated;
use App\Models\ProviderEvaluation;
use App\Models\ProviderEvaluationResponse;
use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ProviderEvaluationService
{
    /**
     * Roles answered by a pool of users instead of one named respondent.
     * A single unassigned response is created for the whole pool and the first
     * user who answers it closes it for the rest.
     *
     * @var array<string, string> respondent_role => role name
     */
    public const POOL_ROLES = [
        'almacen' => 'revisa_almacen_requisicion_compra',
    ];

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
            $role = $question->role();

            // Roles compartidos: una sola respuesta sin asignar para todo el rol
            if (array_key_exists($role, self::POOL_ROLES)) {
                $evaluation->responses()->create([
                    'question' => $question->value,
                    'respondent_role' => $role,
                    'respondent_id' => null,
                    'selected_option' => null,
                    'score' => null,
                    'answered_at' => null,
                ]);

                continue;
            }

            foreach ($respondents[$role] ?? [] as $respondentId) {
                $evaluation->responses()->create([
                    'question' => $question->value,
                    'respondent_role' => $role,
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
        $evaluation->load('responses');

        // Group responses by respondent so each user gets one email.
        // Las filas de pool no tienen respondent_id y no entran al eager load.
        $assigned = $evaluation->responses->whereNotNull('respondent_id');
        $assigned->load('respondent');

        $byRespondent = $assigned->groupBy('respondent_id');

        $company = $order->company?->name ?? '';
        $folio = $order->folio ?? '';
        $provider = $order->provider?->company_name ?? '';
        $requisitionFolio = $order->requisition?->folio ?? '';
        $purchaser = $order->purchaser?->name ?? '';

        /** @var array<int, array{user: User, role: string}> $recipients */
        $recipients = [];

        foreach ($byRespondent as $responses) {
            $respondent = $responses->first()->respondent;

            if ($respondent) {
                $recipients[$respondent->id] = [
                    'user' => $respondent,
                    'role' => $responses->first()->respondent_role,
                ];
            }
        }

        // Las respuestas compartidas se avisan a todo el rol: el primero que responda la cierra
        $poolRoles = $evaluation->responses
            ->whereNull('respondent_id')
            ->pluck('respondent_role')
            ->unique();

        foreach ($poolRoles as $role) {
            foreach (self::poolUsers($role) as $user) {
                $recipients[$user->id] ??= ['user' => $user, 'role' => $role];
            }
        }

        foreach ($recipients as $recipient) {
            if (! $recipient['user']->email) {
                continue;
            }

            Mail::to($recipient['user']->email)->queue(new EvaluationCreated([
                'respondent_name' => $recipient['user']->name,
                'respondent_role' => $recipient['role'],
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
     *
     * Unassigned (pool) responses are claimed by the answering user, so once one
     * member of the role answers it is closed for everyone else.
     *
     * @return bool false when the response was already answered by someone else.
     */
    public static function answer(ProviderEvaluationResponse $response, string $selectedOption, ?User $user = null): bool
    {
        $user ??= auth()->user();
        $question = $response->questionEnum();

        $claimed = ProviderEvaluationResponse::query()
            ->whereKey($response->getKey())
            ->whereNull('answered_at')
            ->update([
                'respondent_id' => $response->respondent_id ?? $user?->id,
                'selected_option' => $selectedOption,
                'score' => $question->scoreForOption($selectedOption),
                'answered_at' => now(),
                'updated_at' => now(),
            ]);

        if ($claimed === 0) {
            return false;
        }

        $response->refresh();
        $response->evaluation->load('responses')->markCompletedIfAllAnswered();

        return true;
    }

    /**
     * Respondent roles the given user may answer as part of a shared pool.
     *
     * @return string[]
     */
    public static function poolRolesFor(?User $user): array
    {
        if (! $user) {
            return [];
        }

        return array_keys(array_filter(
            self::POOL_ROLES,
            fn (string $roleName) => $user->hasRole($roleName)
        ));
    }

    /**
     * Users that make up the pool for a respondent role.
     *
     * @return Collection<int, User>
     */
    private static function poolUsers(string $respondentRole): Collection
    {
        $roleName = self::POOL_ROLES[$respondentRole] ?? null;

        return $roleName
            ? User::withRole($roleName)->get()
            : collect();
    }

    /**
     * @return array<string, int[]> role => list of user_ids
     */
    private static function resolveRespondents(PurchaseOrder $order): array
    {
        return [
            'solicitante' => array_filter([$order->requisition?->approvalChain?->requester_id]),
            'comprador' => array_filter([$order->purchaser_user_id]),
        ];
    }
}
