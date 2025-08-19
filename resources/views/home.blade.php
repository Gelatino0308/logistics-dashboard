<x-layout title="home"> 
    <div class="flex w-full justify-around items-center">
        <img src="{{ asset('storage/images/radar.png') }}" 
                    alt="PROX Logo"
                    class="object-contain object-center max-w-md">
        <div class="flex flex-col gap-4 h-full w-1/3">
            <h1 class="font-bold !text-8xl">PROX</h1>
            <h2 class="text-3xl">An AI-Powered Proximity Alert System for Warehouse Deliveries</h2>
            <x-bladewind::button tag="a" href="{{ route('form') }}" class="rounded-md text-center text-lg">Check Proximity</x-bladewind::button>
        </div>
    </div>
</x-layout>