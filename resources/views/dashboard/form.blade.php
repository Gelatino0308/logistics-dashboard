<x-layout title="Check Proximity"> 
    <form method="POST" action="{{ route('check.proximity') }}">
        @csrf
        <label>Delivery Latitude:</label>
        <input type="text" name="delivery_lat">
        <label>Longitude:</label>
        <input type="text" name="delivery_lon">
        <label>Alert Radius (m):</label>
        <select name="alert_radius">
            <option value="100">100m</option>
            <option value="250" selected>250m</option>
            <option value="500">500m</option>
        </select>
        <button type="submit">Check Proximity</button>
    </form>    
</x-layout>
