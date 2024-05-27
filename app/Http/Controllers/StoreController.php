<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        return Store::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return Store::create($request->all());
    }

    public function show(Store $store)
    {
        return $store;
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $store->update($request->all());
        return $store;
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return response()->noContent();
    }
}
