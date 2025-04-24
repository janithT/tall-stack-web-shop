<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Webshop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen py-10">
        {{ $slot }}
    </div>

    @livewireScripts
    <!-- @vite('resources/js/app.js') -->
</body>
</html>
