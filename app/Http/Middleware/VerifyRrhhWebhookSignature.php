<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRrhhWebhookSignature
{
    /**
     * Verifica la firma HMAC-SHA256 que rrhh envía en el header
     * `X-Webhook-Signature`. La firma se calcula sobre el cuerpo crudo
     * de la petición, por lo que debe compararse contra `getContent()`
     * y nunca contra una versión re-serializada del JSON.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secret = config('services.rrhh.webhook_secret');
        $signature = $request->header('X-Webhook-Signature');

        if (blank($secret) || blank($signature)) {
            abort(401, 'Firma de webhook ausente o secret no configurado.');
        }

        $expected = 'sha256='.hash_hmac('sha256', $request->getContent(), $secret);

        if (! hash_equals($expected, $signature)) {
            abort(401, 'Firma de webhook inválida.');
        }

        return $next($request);
    }
}
