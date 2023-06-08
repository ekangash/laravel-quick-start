<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Laravel Blog RestAPI</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="antialiased">
        <header class="bg-gray-50 text-gray-800 py-4 px-2 shadow-sm">
            <a
                href="/"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-all"
            >
                Laravel Quick Search
            </a>
        </header>
        <main class="max-w-5xl mx-auto mt-12">
            <section class="grid grid-cols-2 gap-6">
                <div class="flex flex-col align-items-center justify-content-center rounded-2xl border border-gray-200 w-100 h-40 p-3">
                    <p class="text-sm">
                        Swagger - это инструмент для документирования и тестирования API, который позволяет быстро и легко понимать, как использовать API блога.
                    </p>
                    <a href="api/swagger" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg transition-all duration-200 text-center mt-4 text-sm">
                        Перейти к документации API Swagger
                    </a>
                </div>
                <div class="flex flex-col align-items-center justify-content-center rounded-2xl border border-gray-200 w-100 h-40 p-3">
                    <p class="text-sm">
                        Telescope - это инструмент для документирования и тестирования API, который позволяет быстро и легко понимать, как использовать API блога.
                    </p>
                    <a href="telescope/requests" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg transition-all duration-200 text-center mt-4 text-sm">
                        Перейти к документации Telescope
                    </a>
                </div>

            </section>
        </main>
    </body>
</html>
