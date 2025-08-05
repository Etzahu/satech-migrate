<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body>
    <main class="grid min-h-full px-6 py-24 bg-white place-items-center sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-6xl font-semibold text-red-600">404</p>
            <h1 class="mt-4 text-5xl font-semibold tracking-tight text-gray-900 text-balance sm:text-7xl">Recurso no encontrado.
            </h1>
            <p class="mt-6 text-lg font-medium text-gray-500 text-pretty sm:text-xl/8">Por favor, consulte con el
                administrador del sitio si cree que esto es un error.</p>
            <div class="flex items-center justify-center mt-10 gap-x-6">
                <a href="{{ route('login') }}"
                    class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Página
                    principal</a>
                <a href="mailto:ahernandezm@gptservices.com?subject=Error 403" class="text-sm font-semibold text-gray-900">Contactar con el soporte
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </main>
</body>
</html>

