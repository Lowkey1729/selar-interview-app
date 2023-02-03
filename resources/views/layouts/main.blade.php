<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <link href="/css/tw-styles.css" rel="stylesheet"/>

    <!-- Styles -->

</head>
<body>
<div class="h-full min-h-full mb-20">


    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <a href="{{url('/')}}" class="text-lg leading-6 font-semibold text-gray-900">{{ $page_title ?? 'Admin Page' }}</a>
                <span>{{ today()->format('jS M, Y') }}</span>
            </div>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8">
            <!-- Replace with your content -->
            <div class="px-4 py-4 sm:px-0">
                 @yield('content')
            </div>
            <!-- /End replace -->
        </div>
    </main>
</div>

</body>
</html>
