<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use App\Traits\SaveImageTrait;

class AboutController extends Controller
{
    use SaveImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::latest()->paginate(10);
        return view('admin.about.index', compact('abouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        $data = $request->except(['_token', 'image']);

        // Handle status field
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage($request->file('image'), 'about');
        }

        About::create($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'About content created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('admin.about.create', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $about = About::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        // Handle status field
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($about->image && file_exists(public_path($about->image))) {
                unlink(public_path($about->image));
            }
            $data['image'] = $this->saveImage($request->file('image'), 'about');
        }

        $about->update($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'About content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $about = About::findOrFail($id);
        
        // Delete image if exists
        if ($about->image && file_exists(public_path($about->image))) {
            unlink(public_path($about->image));
        }

        $about->delete();

        return redirect()->route('admin.about.index')
            ->with('success', 'About content deleted successfully.');
    }
}
