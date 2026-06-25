<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Gudang</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* CSS INI AKAN MEMAKSA GAMBAR MUNCUL DI BODY */
            html, body {
                height: 100%;
                margin: 0;
            }
            body {
                background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                                  url("/images/bg-cafe.jpg") !important;
                background-size: cover !important;
                background-position: center !important;
                background-repeat: no-repeat !important;
                background-attachment: fixed !important;
            }
            /* Hilangkan background bawaan Tailwind yang mungkin menutupi */
            .min-h-screen {
                background-color: transparent !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex items-center justify-center">
            {{ $slot }}
        </div>
    </body>
</html>