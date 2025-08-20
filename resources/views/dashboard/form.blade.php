<x-layout title="Check Proximity">
    @php
        $radius = [
            ['label' => '100m', 'value' => '100'],
            ['label' => '250m', 'value' => '250'],
            ['label' => '500m', 'value' => '500']
        ];
    @endphp

    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Form Section -->
            <div class="flex flex-col justify-center">
                <x-bladewind::notification />
                
                <x-bladewind::card class="h-fit">
                    <form method="POST" action="{{ route('check-proximity') }}" class="space-y-6 form">
                        @csrf

                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">Check Delivery Proximity</h1>
                            <p class="text-sm text-gray-600 mb-6">
                                Click the map or enter the delivery coordinates and your preferred alert radius below to check distance from the warehouse.
                            </p>
                        </div>

                        <x-bladewind::input
                            name="delivery_lat"
                            numeric="true"
                            with_dots="true"
                            step="any"
                            required="true"
                            label="Delivery Latitude:"
                            error_message="You will need to enter a number (integer or decimal)"
                            value="{{ old('delivery_lat') }}"
                        />

                        <x-bladewind::input
                            name="delivery_lon"
                            numeric="true"
                            with_dots="true"
                            step="any"
                            required="true"
                            label="Delivery Longitude:"
                            error_message="You will need to enter a number (integer or decimal)"
                            value="{{ old('delivery_lon') }}"
                        />

                        <x-bladewind::select
                            required="true"
                            name="alert_radius"
                            label="Alert Radius (m)"
                            selected_value="{{ old('alert_radius', '250') }}"
                            placeholder="Choose your preferred alert radius"
                            :data="$radius"
                        />

                        <div class="text-center">
                            <x-bladewind::button
                                name="btn-submit"
                                type="primary"
                                can_submit="true"
                                has_spinner="true"
                                class="w-full"
                            >
                                Analyze Proximity
                            </x-bladewind::button>
                        </div>
                    </form>
                </x-bladewind::card>

                <!-- Display Results Alert -->
                @if(session('proximity_result'))
                    @php $result = session('proximity_result'); @endphp
                    <div class="mt-4">
                        <x-bladewind::alert 
                            type="{{ $result['within_range'] ? 'success' : 'error' }}" 
                            can_close="true"
                        >
                            <div class="font-medium">
                                {{ $result['within_range'] ? 'Within Range!' : 'Out of Range' }}
                            </div>
                            <div class="text-sm mt-1">
                                Delivery is {{ $result['distance'] }} meters 
                                {{ $result['within_range'] ? 'within' : 'away from' }} 
                                the warehouse ({{ $result['radius'] }}m radius).
                            </div>
                        </x-bladewind::alert>
                    </div>
                @endif
            </div>

            <!-- Map Section -->
            <div>
                <x-bladewind::card>
                    <h2 class="text-lg font-semibold mb-4 text-gray-900">Proximity Map</h2>
                    <div id="map" class="map-container"></div>
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <div class="warehouse-marker"></div>
                                <span>Warehouse</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="delivery-marker"></div>
                                <span>Delivery Location</span>
                            </div>
                        </div>
                        @if(session('proximity_result'))
                            <div class="text-xs">
                                Alert Radius: {{ session('proximity_result')['radius'] }}m
                                | Distance: {{ session('proximity_result')['distance'] }}m
                            </div>
                        @endif
                    </div>
                </x-bladewind::card>
            </div>
        </div>

        <!-- Results Modal -->
        @if(session('proximity_result'))
            @php $result = session('proximity_result'); @endphp
            <x-bladewind::modal
                name="proximity-results"
                title="Proximity Analysis Results"
                size="medium"
                backdrop_can_close="true"
                ok_button_label="Close"
                cancel_button_label=""
            >
                <div class="text-center py-6">
                    @if($result['within_range'])
                        <div class="text-green-600">
                            <x-bi-check-circle-fill class="mx-auto h-16 w-16 mb-4"/>
                            <h3 class="text-2xl font-bold mb-2">Within Range!</h3>
                        </div>
                    @else
                        <div class="text-red-600">
                            <x-bi-x-circle-fill class="mx-auto h-16 w-16 mb-4"/>
                            <h3 class="text-2xl font-bold mb-2">Out of Range</h3>
                        </div>
                    @endif
                    
                    <p class="text-gray-600 text-lg">
                        The delivery location is <strong>{{ $result['distance'] }}</strong> meters 
                        {{ $result['within_range'] ? 'within' : 'away from' }} the warehouse.
                    </p>
                    
                    <div class="mt-6 bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium">Alert Radius:</span>
                                {{ $result['radius'] }}m
                            </div>
                            <div>
                                <span class="font-medium">Distance:</span>
                                {{ $result['distance'] }}m
                            </div>
                        </div>
                    </div>
                </div>
            </x-bladewind::modal>

            <script>
                // Auto-show modal on page load if there's a result
                document.addEventListener('DOMContentLoaded', function() {
                    showModal('proximity-results');
                });
            </script>
        @endif
    </div>

    <script>
        // Validation for bladewind input components
        domEl('.form').addEventListener('submit', function (e){
            e.preventDefault();
            if (validateForm('.form')) {
                unhide('.btn-submit .bw-spinner');
                domEl('.form').submit();
            } else {
                hide('.btn-submit .bw-spinner');
            }
        });

        // Simple map initialization
        let map, warehouseMarker, deliveryMarker, radiusCircle;
        const warehouseCoords = [14.5995, 120.9842];

        function initMap() {
            map = L.map('map').setView(warehouseCoords, 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Add warehouse marker
            const warehouseIcon = L.divIcon({
                className: 'warehouse-marker',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });

            warehouseMarker = L.marker(warehouseCoords, { 
                icon: warehouseIcon,
                title: 'Warehouse Location'
            }).addTo(map);
            
            warehouseMarker.bindPopup('<b>Warehouse</b><br>Main Distribution Center');

            // Add click event to set delivery location
            map.on('click', function(e) {
                setDeliveryLocation(e.latlng.lat, e.latlng.lng);
            });

            // If there's a previous result, show it on the map
            @if(session('proximity_result') && old('delivery_lat') && old('delivery_lon'))
                const deliveryLat = {{ old('delivery_lat') }};
                const deliveryLon = {{ old('delivery_lon') }};
                const radius = {{ session('proximity_result')['radius'] }};
                
                addDeliveryMarker(deliveryLat, deliveryLon);
                addRadiusCircle(radius);
                fitMapToContent();
            @endif
        }

        function setDeliveryLocation(lat, lng) {
            document.querySelector('input[name="delivery_lat"]').value = lat.toFixed(6);
            document.querySelector('input[name="delivery_lon"]').value = lng.toFixed(6);
            addDeliveryMarker(lat, lng);
        }

        function addDeliveryMarker(lat, lng) {
            if (deliveryMarker) {
                map.removeLayer(deliveryMarker);
            }

            const deliveryIcon = L.divIcon({
                className: 'delivery-marker',
                iconSize: [16, 16],
                iconAnchor: [8, 8]
            });

            deliveryMarker = L.marker([lat, lng], { 
                icon: deliveryIcon,
                title: 'Delivery Location'
            }).addTo(map);
            
            deliveryMarker.bindPopup(`<b>Delivery Location</b><br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`);
        }

        function addRadiusCircle(radius) {
            if (radiusCircle) {
                map.removeLayer(radiusCircle);
            }
            
            radiusCircle = L.circle(warehouseCoords, {
                color: '#3b82f6',
                fillColor: '#3b82f6',
                fillOpacity: 0.1,
                weight: 2,
                radius: parseInt(radius)
            }).addTo(map);
        }

        function fitMapToContent() {
            const items = [warehouseMarker];
            
            if (deliveryMarker) items.push(deliveryMarker);
            if (radiusCircle) items.push(radiusCircle);
            
            if (items.length > 1) {
                const group = new L.featureGroup(items);
                map.fitBounds(group.getBounds().pad(0.15));
            }
        }

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</x-layout>