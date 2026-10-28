<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Revisión diaria del flujo (purchases:flow-health)
    |--------------------------------------------------------------------------
    |
    | Avisa por correo cuando un nivel del flujo se queda sin nadie activo que
    | lo responda. Ver App\Services\FlowHealthService.
    |
    */

    'flow_alerts' => [

        // Correos separados por coma. Vacío: los usuarios activos con super_admin.
        'recipients' => array_values(array_filter(array_map(
            'trim',
            explode(',', (string) env('FLOW_ALERT_RECIPIENTS', ''))
        ))),

        // Lo que espera a una cuenta inactiva y lleva más de estos días sin
        // moverse se da por abandonado y deja de avisarse. Los roles sin
        // titular se avisan siempre.
        'idle_days' => (int) env('FLOW_ALERT_IDLE_DAYS', 30),

    ],

    /*
    |--------------------------------------------------------------------------
    | Recordatorio de pendientes (purchases:remind-pending)
    |--------------------------------------------------------------------------
    |
    | Le vuelve a avisar a cada responsable lo que espera su revisión en
    | cualquier nivel del flujo. Ver App\Services\PendingReviewReminderService.
    |
    */

    'reminders' => [

        // Lo que lleva menos de estos días en el nivel no se recuerda: el aviso
        // original acaba de salir. 0 recuerda todo.
        'min_days' => (int) env('REVIEW_REMINDER_MIN_DAYS', 1),

        // URL a la que se avisa cuando el recordatorio termina sin errores
        // (healthchecks.io, Oh Dear). Vacío: no se avisa a nadie.
        'ping_url' => env('REVIEW_REMINDER_PING_URL'),

    ],

];
