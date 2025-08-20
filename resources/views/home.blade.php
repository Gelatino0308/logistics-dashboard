<x-layout title="Home"> 
    <div class="flex w-full justify-center items-center gap-18">
        <img src="{{ asset('storage/images/radar.png') }}" 
                    alt="PROX Logo"
                    class="object-contain object-center !max-w-sm">
        <div class="flex flex-col gap-4 h-full w-1/3 items-center">
            <h1 class="font-bold !text-8xl">PROX</h1>
            <h2 class="text-3xl text-center">An AI-Powered Proximity Alert System for Warehouse Deliveries</h2>
            <a href="{{ route('form') }}">
                <x-bladewind::button class="rounded-md text-center text-lg">Check Proximity</x-bladewind::button>
            </a>
        </div>
    </div>
</x-layout>