<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialOffer;
use App\Models\Product;
use Illuminate\Http\Request;

class SpecialOfferController extends Controller
{
    public function index()
    {
        $offers = SpecialOffer::with('product')->get();
        return view('admin.special-offers.index', compact('offers'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.special-offers.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'boolean'
        ]);

        SpecialOffer::create($validated);

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer created successfully.');
    }

    public function edit(SpecialOffer $specialOffer)
    {
        $products = Product::all();
        return view('admin.special-offers.edit', compact('specialOffer', 'products'));
    }

    public function update(Request $request, SpecialOffer $specialOffer)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'boolean'
        ]);

        $specialOffer->update($validated);

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer updated successfully.');
    }

    public function destroy(SpecialOffer $specialOffer)
    {
        $specialOffer->delete();

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer deleted successfully.');
    }
}
