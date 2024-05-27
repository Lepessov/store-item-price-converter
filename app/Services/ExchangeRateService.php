<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getRates()
    {
        try {
            $response = $this->client->get('https://v6.exchangerate-api.com/v6/7e3aae7f1e044f6913fd3a83/latest/USD');
            $data = json_decode($response->getBody()->getContents(), true);

            Log::error('Exchange rates API response', $data);
            if (!isset($data['conversion_rates'])) {
                Log::error('Exchange rates API response does not contain rates key', $data);
                throw new \Exception('Exchange rates API response does not contain rates key');
            }

            return $data['conversion_rates'];
        } catch (\Exception $e) {
            Log::error('Failed to fetch exchange rates: ' . $e->getMessage());
            return [];
        }
    }

    public function convert($amount, $from, $to)
    {
        $rates = $this->getRates();

        if ($from !== 'USD') {
            $amount = $amount / $rates[$from];
        }

        return $amount * $rates[$to];
    }
}

