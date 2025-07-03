<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialOffer;
use App\Models\Product;
use App\Traits\SaveImageTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SpecialOfferController extends Controller
{
    use SaveImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = SpecialOffer::ordered()->paginate(10);
        return view('admin.special-offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::active()->select('id', 'name', 'price')->orderBy('name')->get();
        return view('admin.special-offers.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean'
        ]);

        $data = $request->except(['image']);

        // Handle status field
        $data['status'] = $request->has('status') && $request->status == 'active' ? 'active' : 'inactive';
        
        // Handle is_featured field
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage($request->file('image'), 'special-offers');
        }

        SpecialOffer::create($data);

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SpecialOffer $specialOffer)
    {
        $specialOffer->load('product.category');
        return view('admin.special-offers.show', compact('specialOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $offer = SpecialOffer::findOrFail($id);
        $products = Product::active()->select('id', 'name', 'price')->orderBy('name')->get();
        return view('admin.special-offers.create', compact('offer', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $specialOffer = SpecialOffer::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean'
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        // Handle status field
        $data['status'] = $request->has('status') && $request->status == 'active' ? 'active' : 'inactive';
        
        // Handle is_featured field
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($specialOffer->image && file_exists(public_path($specialOffer->image))) {
                unlink(public_path($specialOffer->image));
            }
            $data['image'] = $this->saveImage($request->file('image'), 'special-offers');
        }

        $specialOffer->update($data);

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $specialOffer = SpecialOffer::findOrFail($id);
        
        // Delete image if exists
        if ($specialOffer->image && file_exists(public_path($specialOffer->image))) {
            unlink(public_path($specialOffer->image));
        }

        $specialOffer->delete();

        return redirect()->route('admin.special-offers.index')
            ->with('success', 'Special offer deleted successfully.');
    }

    /**
     * Toggle offer status
     */
    public function toggleStatus(SpecialOffer $specialOffer)
    {
        $newStatus = $specialOffer->status === 'active' ? 'inactive' : 'active';
        
        // Don't allow activation if offer has expired
        if ($newStatus === 'active' && $specialOffer->is_expired) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot activate expired offer.'
            ], 400);
        }

        $specialOffer->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $specialOffer->status,
            'message' => 'Special offer status updated successfully.'
        ]);
    }

    /**
     * Get current offers (AJAX)
     */
    public function getCurrentOffers()
    {
        $offers = SpecialOffer::with('product')
            ->current()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'offers' => $offers
        ]);
    }

    /**
     * Update sort order
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:special_offers,id',
            'items.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            SpecialOffer::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sort order updated successfully.'
        ]);
    }

    /**
     * Extend offer end date
     */
    public function extendOffer(Request $request, SpecialOffer $specialOffer)
    {
        $request->validate([
            'new_end_date' => 'required|date|after:' . $specialOffer->start_date
        ]);

        $specialOffer->update([
            'end_date' => $request->new_end_date,
            'status' => 'active' // Reactivate if it was expired
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Offer extended successfully.',
            'new_end_date' => $specialOffer->end_date->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Duplicate offer
     */
    public function duplicate(SpecialOffer $specialOffer)
    {
        $newOffer = $specialOffer->replicate();
        $newOffer->title = $specialOffer->title . ' (Copy)';
        $newOffer->start_date = Carbon::now();
        $newOffer->end_date = Carbon::now()->addDays(7);
        $newOffer->status = 'inactive';
        $newOffer->save();

        return redirect()->route('admin.special-offers.edit', $newOffer)
            ->with('success', 'Special offer duplicated successfully. Please update the details.');
    }
}
