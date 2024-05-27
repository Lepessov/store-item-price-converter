<?php

namespace App\Http\Controllers;

use App\Services\ExchangeRateService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected ExchangeRateService $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function convert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'from' => 'required|string',
            'to' => 'required|string',
        ]);

        $amount = $request->input('amount');
        $from = $request->input('from');
        $to = $request->input('to');

        $convertedAmount = $this->exchangeRateService->convert($amount, $from, $to);

        return response()->json(['converted_amount' => $convertedAmount]);
    }
}
