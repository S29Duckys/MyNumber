<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MyNumber') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-950 text-white font-sans antialiased flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2">
                <div class="w-9 h-9 bg-indigo-500 rounded-xl flex items-center justify-center font-bold">M</div>
                <span class="text-xl font-semibold tracking-tight">MyNumber</span>
            </a>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8">
            {{ $slot }}
        </div>

    </div>

</body>
</html>
