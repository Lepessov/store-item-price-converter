<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('stores', StoreController::class);
Route::apiResource('purchases', PurchaseController::class);
Route::post('currency/convert', [CurrencyController::class, 'convert']);
Route::get('test-currency-conversion', function () {
    return view('test');
});
