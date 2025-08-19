<x-layout title="Check Proximity"> 
    @php
        $radius = [
            ['label' => '100m', 'value' => '100'],
            ['label' => '250m', 'value' => '250'],
            ['label' => '500m', 'value' => '500']

        ];
    @endphp
    
    <x-bladewind::notification />

    <x-bladewind::card class="max-w-1/4">

        <form method="POST" class="form">
            @csrf

            <h1 class="my-2 text-2xl font-bold">Check Delivery Proximity</h1>
            <p class="mt-3 !mb-6 text-sm">
                Click the map or enter the deliver coordinates and your preferred alert radius below to check distance from the warehouse.
            </p>

            <x-bladewind::input
                name="delivery_lat"
                numeric="true"
                with_dots="true"
                step="any"
                required="true"
                label="Delivery Latitude:"
                error_message="You will need to enter a number (integer or decimal)" 
            />

            <x-bladewind::input
                name="delivery_lon"
                numeric="true"
                with_dots="true"
                step="any"
                required="true"
                label="Delivery Longitude:"
                error_message="You will need to enter a number (integer or decimal)" 
            />

            <x-bladewind::select
                name="alert_radius"
                required="true"
                label="Alert Radius (m)"
                selected_value="250"
                placeholder="Choose your preferred alert radius"
                :data="$radius"
            />

            <div class="text-center">

                <x-bladewind::button
                    name="btn-submit"
                    has_spinner="true"
                    type="primary"
                    can_submit="true"
                    class="mt-3"
                >
                    Analyze
                </x-bladewind::button>

            </div>

        </form>

    </x-bladewind::card>


</x-layout>

<script>
    domEl('.form').addEventListener('submit', function (e){
        e.preventDefault();
        signUp();
    });

    signUp = () => {
        (validateForm('.form')) ?
            unhide('.btn-submit .bw-spinner') : 
            hide('.btn-submit .bw-spinner'); 
    }
</script>
