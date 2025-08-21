<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Home' }} - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="text-black min-h-screen flex flex-col">
    <nav class="h-20 px-6 grid grid-cols-2 justify-center items-center bg-black shadow-lg text-white">
        {{-- Logo and name --}}
        <div class="flex justify-start items-center gap-2">
            <div>
                <x-zondicon-radar class="!w-8"/>
            </div>
            <span class="text-xl font-medium">PROX</span>
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

    <main class="py-8 px-4 relative flex justify-center items-center flex-1 self-center w-full">
        {{ $slot }}
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
            crossorigin="">
    </script>
</body>
</html>