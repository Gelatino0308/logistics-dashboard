<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProximityAlertController extends Controller
{
    public function checkProximity(Request $request)
    {
        $response = Http::post('https://flask-proximity-api-53t9.onrender.com/check_proximity', [
            'warehouse' => [14.5995, 120.9842],
            'delivery' => [(float)$request->lat, (float)$request->lng],
            'radius' => (int)($request->radius ?? 250)
        ]);

        return view('dashboard.alerts', ['data' => $response->json()]);
    }

}
