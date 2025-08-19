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

        // Validate fields
        $fields = $request->validate([
            'delivery_lat' => ['required', 'numeric'],
            'delivery_lon' => ['required', 'numeric'],
            'alert_radius' => ['required', 'integer']
        ]);

        // Send request to API 
        $response = Http::post($proxApiUrl, [
            'warehouse' => $WHCoordinates,
            'delivery' => [(float)$fields['delivery_lat'], (float)$fields['delivery_lon']],
            'radius' => (int)($fields['alert_radius'])
        ]);

        $responseData = $response->json();

        // Create record in db
        AlertLog::create([
            ...$fields,
            'distance' => $responseData['distance'],
            'is_within_range?' => $responseData['within_range']
        ]);

        // Store result in session and redirect back
        return back()->with('proximity_result', [
            'within_range' => $responseData['within_range'],
            'distance' => round($responseData['distance']),
            'radius' => $fields['alert_radius'],
            'delivery_lat' => $fields['delivery_lat'],
            'delivery_lon' => $fields['delivery_lon']
        ])->withInput();
    }

}
