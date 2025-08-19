<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Home' }} - {{ env('APP_NAME') }}</title>
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-black min-h-screen flex flex-col">
    <nav class="h-20 px-4 grid grid-cols-2 items-center bg-black shadow-lg text-white">
        {{-- Logo and name --}}
        <div class="flex justify-start">
            <a href="" class="nav-link">
                <x-bi-lightning-fill class="inline"/>
                <span>PROX</span>
            </a>
        </div>

        {{-- Nav links --}}
        <div class="flex justify-end">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('form') }}" class="nav-link">Check Proximity</a>
                <a href="{{ route('logs') }}" class="nav-link">Logs</a>
            </div>
        </div>
    </nav>

    <main class="py-8 px-4 max-w-screen-lg relative flex justify-center items-center flex-1 self-center w-full">
        {{ $slot }}
    </main>
</body>
</html>