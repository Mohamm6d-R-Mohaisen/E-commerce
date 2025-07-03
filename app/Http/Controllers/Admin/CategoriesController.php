<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\SaveImageTrait;

class CategoriesController extends Controller
{
    use SaveImageTrait;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|in:active,archived'
        ]);

        $data = $request->except(['_token', 'image']);
        
        // Handle status field
        $data['status'] = $request->has('status') && $request->status == 'active' ? 'active' : 'archived';
        
        // Handle slug
        $data['slug'] = Str::slug($request->name);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage($request->file('image'), 'categories');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', __('تم إنشاء الفئة بنجاح!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.create', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|in:active,archived'
        ]);

        $data = $request->except(['_token', '_method', 'image']);
        
        // Handle status field
        $data['status'] = $request->has('status') && $request->status == 'active' ? 'active' : 'archived';
        
        // Update slug only if name changed
        if ($request->name !== $category->name) {
            $data['slug'] = Str::slug($request->name);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $data['image'] = $this->saveImage($request->file('image'), 'categories');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', __('تم تحديث الفئة بنجاح!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete image if exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', __('تم حذف الفئة بنجاح!'));
    }
}
