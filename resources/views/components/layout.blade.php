<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>{{ config('app.name', 'Laravel') }}</title>
    @livewireStyles
    @filamentStyles
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 font-cairo">
    @livewire('nav-bar')

    <main>
        {{ $slot }}
    </main>
</div>

@filamentScripts
@livewireScripts
@vite('resources/js/app.js')
</body>
<style>
    .custom-gradient {
        background-image: linear-gradient(
            285deg,
            rgba(90,64,117,1) 0%,
            rgba(75,88,140,1) 20%,
            rgba(62,110,160,1) 59%,
            rgba(53,124,173,1) 72%,
            rgba(44,140,188,1) 92%,
            rgba(35,154,201,1) 100%,
            rgba(0,212,255,1) 100%
        );
    }
</style>
</html>
