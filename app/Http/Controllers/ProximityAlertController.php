<?php

namespace App\Http\Controllers;

use App\Models\AlertLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProximityAlertController extends Controller
{
    public function checkProximity(Request $request)
    {
        $proxApiUrl = 'https://flask-proximity-api-53t9.onrender.com/check_proximity';
        $WHCoordinates = [14.5995, 120.9842];

        $fields = $request->validate([
            'delivery_lat' => ['required', 'numeric'],
            'delivery_lon' => ['required', 'numeric'],
            'alert_radius' => ['required', 'integer']
        ]);

        $response = Http::post($proxApiUrl, [
            'warehouse' => $WHCoordinates,
            'delivery' => [$fields['delivery_lat'], $fields['delivery_lon']],
            'radius' => (int)($fields['alert_radius'])
        ]);

        $responseData = $response->json();

        AlertLog::create([
            ...$fields,
            'distance' => $responseData['distance'],
            'is_within_range?' => $responseData['within_range']
        ]);

        return view('dashboard.alerts', [
            'data' => $responseData,
            'warehouse' => $WHCoordinates,
            'delivery' => [$fields['delivery_lat'], $fields['delivery_lon']],
            'radius' => $fields['alert_radius']
        ]);
    }

}
