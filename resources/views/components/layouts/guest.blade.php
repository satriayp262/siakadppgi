<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
        }
        .spinner {
                border: 5px solid rgba(0, 0, 0, 0.2);
                /* Light border for background */
                border-radius: 50%;
                border-top: 5px solid #3498db;
                /* Blue border for spinner */
                width: 36px;
                /* Increased size for visibility */
                height: 36px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
    </style>
    @vite('resources/css/app.css')
    <title>SIAKAD {{ $title ?? 'PPGI' }}</title>
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

</head>

<body class="flex flex-col min-h-screen bg-gray-200">

                {{ $slot }}
    @livewireScripts
</body>

</html>
