<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NetworkUs
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->

</head>

<body class="antialiased">
    <div class="flex justify-center items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-3xl w-full px-6 lg:px-8">
            <div class="text-center">
                <!-- Иконка -->
                <div class="flex items-center justify-center rounded-full mx-auto">
                    <img class="block h-9 w-auto fill-current text-gray-800" src="{{ asset('images/US-Logo-1.png') }}" alt="лого">
                    
                </div>


                <!-- Заголовок -->
                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
                    Добро пожаловать в NetworkUs
                </h2>

                <!-- Описание -->
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed max-w-md mx-auto">
                    Уникальный рекламный кабинет, объединяющий рекламодателей и веб-мастеров, для достижения общих целей
                </p>
                @if (Route::has('login'))
                <div class="pt-2 text-center z-10">
                    @auth
                        @if(Auth::user()->role === 'user')
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Войти в личный кабинет</a>
                        @endif
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ url('/admin_panel') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Войти в панель веб-администратора</a>
                        @endif
                    @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Войти в кабинет</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Зарегистрироваться</a>
                    @endif
                    @endauth
                </div>
                @endif
            </div>

            <!-- Копирайт и версия -->
            <div class="flex justify-center mt-16 pt-16 px-0 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                    <div class="flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>by Ivan Us
                    </div>
                </div>

                <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                    NetworkUs v1.0 (Beta)
                </div>
            </div>
        </div>
    </div>

</body>

</html>