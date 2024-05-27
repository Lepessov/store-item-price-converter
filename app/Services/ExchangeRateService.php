<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
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
        return Cache::remember('exchange_rates', 3600, function () {
            try {
                $response = $this->client->get('https://api.exchangeratesapi.io/latest', [
                    'query' => [
                        'access_key' => env('EXCHANGE_RATE_API_KEY'),
                        'base' => 'USD'
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                Log::info('Exchange rates API response', $data);

                if (!isset($data['rates'])) {
                    Log::error('Exchange rates API response does not contain rates key', $data);
                    throw new \Exception('Exchange rates API response does not contain rates key');
                }

                return $data['rates'];
            } catch (\Exception $e) {
                Log::error('Failed to fetch exchange rates: ' . $e->getMessage());
                return [];
            }
        });
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

