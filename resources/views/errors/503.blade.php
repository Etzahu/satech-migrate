<!DOCTYPE html>
<html lang="es" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>En mantenimiento</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body class="h-full">
    <main class="grid min-h-full px-6 py-24 bg-white place-items-center sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-6xl font-semibold text-red-600">503</p>
            <h1 class="mt-4 text-5xl font-semibold tracking-tight text-gray-900 text-balance sm:text-7xl">Estamos en
                mantenimiento.
            </h1>
            <p class="mt-6 text-lg font-medium text-gray-500 text-pretty sm:text-xl/8">La aplicación no está disponible
                mientras realizamos tareas de actualización. Volveremos en breve.</p>

            @isset($retryAfter)
                <p class="mt-4 text-base font-medium text-gray-400">
                    Vuelva a intentarlo en
                    @if ($retryAfter >= 60)
                        {{ (int) ceil($retryAfter / 60) }} minuto{{ ceil($retryAfter / 60) == 1 ? '' : 's' }}.
                    @else
                        {{ (int) $retryAfter }} segundos.
                    @endif
                </p>
            @endisset

            <div class="flex items-center justify-center mt-10 gap-x-6">
                <button type="button" onclick="window.location.reload()"
                    class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Reintentar</button>
                <a href="mailto:ahernandezm@gptservices.com?subject=Mantenimiento" class="text-sm font-semibold text-gray-900">Contactar con el soporte
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </main>
</body>
</html>
