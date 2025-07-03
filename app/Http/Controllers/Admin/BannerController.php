<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Traits\SaveImageTrait;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use SaveImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::ordered()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:100',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Banner::TYPES)),
            'position' => 'required|in:' . implode(',', array_keys(Banner::POSITIONS)),
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->except(['_token', 'background_image']);
        
        // Handle status field
        $data['status'] = $request->has('status') && $request->status == 'active' ? 'active' : 'inactive';

        // Handle image upload
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->saveImage($request->file('background_image'), 'banners');
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.create', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:100',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Banner::TYPES)),
            'position' => 'required|in:' . implode(',', array_keys(Banner::POSITIONS)),
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->except(['_token', '_method', 'background_image']);
        
        // Handle status field
        $data['status'] = $request->has('status') && $request->status == 'active' ? 'active' : 'inactive';

        // Handle image upload
        if ($request->hasFile('background_image')) {
            // Delete old image if exists
            if ($banner->background_image && file_exists(public_path($banner->background_image))) {
                unlink(public_path($banner->background_image));
            }
            $data['background_image'] = $this->saveImage($request->file('background_image'), 'banners');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        // Delete image if exists
        if ($banner->background_image && file_exists(public_path($banner->background_image))) {
            unlink(public_path($banner->background_image));
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }

    /**
     * Toggle banner status
     */
    public function toggleStatus(Banner $banner)
    {
        $banner->update([
            'status' => $banner->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'status' => $banner->status,
            'message' => 'Banner status updated successfully.'
        ]);
    }

    /**
     * Get banners by type (AJAX)
     */
    public function getByType(Request $request)
    {
        $type = $request->get('type');
        $banners = Banner::active()->ofType($type)->ordered()->get();
        
        return response()->json([
            'success' => true,
            'banners' => $banners
        ]);
    }

    /**
     * Update sort order
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:banners,id',
            'items.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            Banner::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sort order updated successfully.'
        ]);
    }
}
