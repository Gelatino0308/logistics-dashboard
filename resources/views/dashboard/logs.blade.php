<x-layout title="Logs">
    @php
        $radiusColors = [
            '100' => 'bg-gray-400',
            '250' => 'bg-gray-600',
            '500' => 'bg-black'
        ];
    @endphp
    
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Proximity Check Logs</h1>
            <p class="text-gray-600">History of all delivery proximity analysis requests</p>
        </div>

        @if($logs->count() > 0)
            <!-- Summary Statistics -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <x-bladewind::card class="text-center">
                    <div class="text-2xl font-bold">{{ $logs->total() }}</div>
                    <div class="text-sm text-gray-600">Total Checks</div>
                </x-bladewind::card>

                <x-bladewind::card class="text-center">
                    <div class="text-2xl font-bold text-green-500">
                        {{ $logs->where('is_within_range?', 1)->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Within Range</div>
                </x-bladewind::card>

                <x-bladewind::card class="text-center">
                    <div class="text-2xl font-bold text-red-500">
                        {{ $logs->where('is_within_range?', 0)->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Outside Range</div>
                </x-bladewind::card>
            </div>

            <x-bladewind::card>
                <x-bladewind::table
                    searchable="true"
                    search_placeholder="Search logs..."
                    has_border="true"
                    divider="thin"
                    compact="true"
                    striped="true"
                    hoverable="true"
                >
                    <x-slot name="header">
                        <th class="!text-center">ID</th>
                        <th class="!text-center">Date & Time</th>
                        <th class="!text-center">Delivery Latitude</th>
                        <th class="!text-center">Delivery Longitude</th>
                        <th class="!text-center">Alert Radius (m)</th>
                        <th class="!text-center">Distance (m)</th>
                        <th class="!text-center">Status</th>
                    </x-slot>

                    @foreach($logs as $log)
                        <tr class="!text-center" >
                            <td class="font-medium">{{ $log->id }}</td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $log->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs text-gray-500">{{ $log->created_at->format('g:i A') }}</span>
                                </div>
                            </td>
                            <td>{{ number_format($log->delivery_lat, 2) }}</td>
                            <td>{{ number_format($log->delivery_lon, 2) }}</td>
                            <td>
                                <span class="px-2 py-1 text-white rounded-full text-xs font-medium {{$radiusColors[$log->alert_radius]}}">
                                    {{ $log->alert_radius }}m
                                </span>
                            </td>
                            <td class="font-medium">
                                {{ number_format($log->distance, 2) }}m
                            </td>
                            <td>
                                @if($log->{'is_within_range?'} == 1)
                                    <span class="w-3/4 inline-flex items-center justify-center py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <x-bi-check-circle-fill class="w-3 h-3 mr-1"/>
                                        Within Range
                                    </span>
                                @else
                                    <span class="w-3/4 inline-flex items-center justify-center px-1 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <x-bi-x-circle-fill class="w-3 h-3 mr-1"/>
                                        Outside Range
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-bladewind::table>
            </x-bladewind::card>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $logs->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <x-bladewind::card>
                    <div class="py-8">
                        <x-heroicon-o-document class="mx-auto h-16 w-16 text-gray-400 mb-4"/>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No logs found</h3>
                        <p class="text-gray-600 mb-4">
                            There are no proximity check logs yet. Start by performing a proximity analysis.
                        </p>
                        <x-bladewind::button>
                            <a href="{{ route('form') }}" class="text-white">
                                Check Proximity
                            </a>
                        </x-bladewind::button>
                    </div>
                </x-bladewind::card>
            </div>
        @endif
    </div>
</x-layout>