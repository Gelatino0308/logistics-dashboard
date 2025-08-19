<x-layout title="home"> 
    <div class="flex w-full justify-around items-center">
        <img src="{{ asset('storage/images/radar.png') }}" 
                    alt="PROX Logo"
                    class="object-contain object-center max-w-md">
        <div class="flex flex-col gap-4 h-full w-1/3">
            <h1 class="font-bold text-5xl">PROX</h1>
            <h2 class="text-2xl">An AI-Powered Proximity Alert System for Warehouse Deliveries</h2>
            <a href="{{ route('form') }}">
                <x-bladewind::button class="rounded-md">Check Proximity</x-bladewind::button>
            </a>
        </div>
    </div>
</x-layout>