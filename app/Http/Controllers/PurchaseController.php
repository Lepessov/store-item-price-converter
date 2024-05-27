<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        return Purchase::with('store')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'document' => 'nullable|file|mimes:jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents');
            $request->merge(['document_path' => $path]);
        }

        return Purchase::create($request->all());
    }

    public function show(Purchase $purchase)
    {
        return $purchase;
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'document' => 'nullable|file|mimes:jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents');
            $request->merge(['document_path' => $path]);
        }

        $purchase->update($request->all());
        return $purchase;
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return response()->noContent();
    }
}
