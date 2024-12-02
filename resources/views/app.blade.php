<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />

    <!-- CSS Links -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia

    <!-- Cargar scripts de Metronic después de que Vue.js esté listo -->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <!-- Scripts personalizados (si es necesario) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof KTUtil !== 'undefined') {
                console.log('Inicializando KTUtil...');
                KTUtil.init();
            }
        });
    </script>
</body>

</html>
