@if ($data['within_range'])
    <p style="color: green;"> Delivery is within {{ $data['distance'] }} meters!</p>
@else
    <p style="color: red;"> Delivery is {{ $data['distance'] }} meters away.</p>
@endif
