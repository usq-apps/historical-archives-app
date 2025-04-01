<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="flex flex-col justify-center items-center min-h-screen">
            <!-- Animated Logo -->
            <div class="flex flex-col items-center">
                <x-application-logo id="logo" class="w-48 h-48 fill-current text-[#FFB448]" />

                <!-- Logo Shadow -->
                <svg height="40" width="240" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <radialGradient id="grad1" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
                            <stop id="logoShadowGrad" offset="0%" stop-color="#dfdfdf" />
                            <stop offset="100%" stop-color="#ffffff" />
                        </radialGradient>
                    </defs>
                    <ellipse id="logoShadowEllipse" cx="120" cy="20" rx="120" ry="10" fill="url(#grad1)" />
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-center text-gray-700 md:text-5xl text-3xl my-4">Historical Archives Timeline</h1>

            <!-- Login -->
            @if (Route::has('login'))
                <div class="px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-xl text-gray-700 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-xl text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-xl text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="fixed right-8 bottom-8">
                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script>
            'use strict';
            const logoTimeline = gsap.timeline({ repeat: -1, repeatDelay: 0.6, yoyo: true });

            logoTimeline.fromTo("#logo", {y: 8}, {y: -8, duration: 2, ease: "sine.inOut"}, 0)
                .fromTo("#logoShadowEllipse", {attr: {rx: "120"}}, {attr: {rx: "70"}, duration: 2, ease: "sine.inOut"}, 0)
                .fromTo("#logoShadowGrad", {stopColor: "#bfbfbf"}, {stopColor: "#dfdfdf", duration: 2, ease: "sine.inOut"}, 0);
        </script>
    </body>
</html>
