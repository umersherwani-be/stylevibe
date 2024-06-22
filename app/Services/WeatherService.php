<?php
namespace App\Services;

use GuzzleHttp\Client;

class WeatherService
{
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        // dd(config('services.openweathermap.key'));
        $this->apiKey = config('services.openweathermap.key');
        $this->client = new Client([
            'base_uri' => 'https://api.openweathermap.org/data/2.5/',
        ]);
    }

    public function getCurrentTemperature($city)
    {
        $response = $this->client->request('GET', 'weather', [
            'query' => [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['main']['temp'];
    }
}
