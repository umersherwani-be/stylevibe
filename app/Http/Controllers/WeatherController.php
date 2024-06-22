<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getCurrentTemperature(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
        ]);

        $city = $request->input('city');
        $temperature = $this->weatherService->getCurrentTemperature($city);

        return response()->json([
            'city' => $city,
            'temperature' => $temperature,
        ]);
    }
}

