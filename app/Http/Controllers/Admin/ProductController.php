<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\SaveImageTrait;

class ProductController extends Controller
{
    use SaveImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with(['category'])->paginate();
        return view('admin.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::where('status', 'active')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|in:active',
            'featured' => 'sometimes|boolean',
            'tags' => 'nullable|string',
            // Product Details validation
            'sku' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
            'weight_unit' => 'nullable|string|in:kg,g,lb,oz',
            'long_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'colors' => 'nullable|array',
            'variants' => 'nullable|array',
            'features' => 'nullable|array',
            'specifications_keys' => 'nullable|array',
            'specifications_values' => 'nullable|array',
            'shipping' => 'nullable|array'
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'quantity', 'compare_price']);
        
        // Generate slug from name
        $data['slug'] = Str::slug($request->name);
        
        // Handle status
        $data['status'] = $request->has('status') ? 'active' : 'archived';
        
        // Handle featured
        $data['featured'] = $request->has('featured') ? 1 : 0;
        
      

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage($request->file('image'), 'products');
        }
        
        $product = Product::create($data);

        // Handle tags
        if ($request->post('tags')) {
            $tags = json_decode($request->post('tags'));
            $tag_ids = [];
            
            if ($tags) {
                foreach ($tags as $item) {
                    $slug = Str::slug($item->value);
                    $tag = Tags::where('slug', $slug)->first();
                    if (!$tag) {
                        $tag = Tags::create([
                            'name' => $item->value,
                            'slug' => $slug,
                        ]);
                    }
                    $tag_ids[] = $tag->id;
                }
                $product->tags()->sync($tag_ids);
            }
        }

        // Handle product details
        $this->saveProductDetails($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إنشاء المنتج بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'tags'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::with('details')->findOrFail($id);
        $categories = Category::where('status', 'active')->get();
        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        return view('admin.products.create', compact('product', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|in:active',
            'featured' => 'sometimes|boolean',
            'tags' => 'nullable|string',
            // Product Details validation
            'sku' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
            'weight_unit' => 'nullable|string|in:kg,g,lb,oz',
            'long_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'colors' => 'nullable|array',
            'variants' => 'nullable|array',
            'features' => 'nullable|array',
            'specifications_keys' => 'nullable|array',
            'specifications_values' => 'nullable|array',
            'shipping' => 'nullable|array'
        ]);

        $product = Product::findOrFail($id);
        $data = $request->only(['name', 'category_id', 'description', 'price', 'quantity', 'compare_price']);
        
        // Update slug if name changed
        if ($request->name !== $product->name) {
            $data['slug'] = Str::slug($request->name);
        }
        
        // Handle status
        $data['status'] = $request->has('status') ? 'active' : 'archived';
        
        // Handle featured
        $data['featured'] = $request->has('featured') ? 1 : 0;
        
        $old_image = $product->image;

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage($request->file('image'), 'products');
        }

        $product->update($data);
        
        // Delete old image if new one was uploaded
        if ($old_image && isset($data['image'])) {
            $this->deleteImage($old_image);
        }

        // Handle tags
        if ($request->post('tags')) {
            $tags = json_decode($request->post('tags'));
            $tag_ids = [];
            
            if ($tags) {
                foreach ($tags as $item) {
                    $slug = Str::slug($item->value);
                    $tag = Tags::where('slug', $slug)->first();
                    if (!$tag) {
                        $tag = Tags::create([
                            'name' => $item->value,
                            'slug' => $slug,
                        ]);
                    }
                    $tag_ids[] = $tag->id;
                }
            }
            $product->tags()->sync($tag_ids);
        } else {
            $product->tags()->sync([]);
        }

        // Handle product details
        $this->saveProductDetails($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح!');
    }

    /**
     * Save product details
     */
    private function saveProductDetails(Product $product, Request $request)
    {
        $detailsData = [];

        // Handle colors
        if ($request->has('colors')) {
            $colors = [];
            foreach ($request->input('colors', []) as $color) {
                if (!empty($color['name'])) {
                    $colors[] = [
                        'name' => $color['name'],
                        'value' => $color['value'] ?? '#000000',
                        'available' => isset($color['available']) ? true : false
                    ];
                }
            }
            $detailsData['colors'] = $colors;
        }

        // Handle variants
        if ($request->has('variants')) {
            $variants = [];
            foreach ($request->input('variants', []) as $variant) {
                if (!empty($variant['type'])) {
                    $options = [];
                    if (!empty($variant['options'])) {
                        $options = array_map('trim', explode(',', $variant['options']));
                    }
                    
                    $variants[] = [
                        'type' => $variant['type'],
                        'label' => $variant['label'] ?? $variant['type'],
                        'options' => $options
                    ];
                }
            }
            $detailsData['variants'] = $variants;
        }

        // Handle features
        if ($request->has('features')) {
            $features = array_filter($request->input('features', []), function($feature) {
                return !empty(trim($feature));
            });
            $detailsData['features'] = array_values($features);
        }

        // Handle specifications
        if ($request->has('specifications_keys') && $request->has('specifications_values')) {
            $keys = $request->input('specifications_keys', []);
            $values = $request->input('specifications_values', []);
            $specifications = [];
            
            for ($i = 0; $i < count($keys); $i++) {
                if (!empty($keys[$i]) && !empty($values[$i])) {
                    $specifications[$keys[$i]] = $values[$i];
                }
            }
            $detailsData['specifications'] = $specifications;
        }

        // Handle shipping options
        if ($request->has('shipping')) {
            $shippingOptions = [];
            foreach ($request->input('shipping', []) as $shipping) {
                if (!empty($shipping['name'])) {
                    $shippingOptions[] = [
                        'name' => $shipping['name'],
                        'time' => $shipping['time'] ?? '',
                        'price' => $shipping['price'] ?? 0
                    ];
                }
            }
            $detailsData['shipping_options'] = $shippingOptions;
        }

        // Handle other details fields
        if ($request->filled('sku')) {
            $detailsData['sku'] = $request->input('sku');
        }
        
        if ($request->filled('weight')) {
            $detailsData['weight'] = $request->input('weight');
            $detailsData['weight_unit'] = $request->input('weight_unit', 'kg');
        }
        
        if ($request->filled('long_description')) {
            $detailsData['long_description'] = $request->input('long_description');
        }
        
        if ($request->filled('meta_title')) {
            $detailsData['meta_title'] = $request->input('meta_title');
        }
        
        if ($request->filled('meta_description')) {
            $detailsData['meta_description'] = $request->input('meta_description');
        }
        
        if ($request->filled('meta_keywords')) {
            $detailsData['meta_keywords'] = $request->input('meta_keywords');
        }

        // Save or update product details
        if (!empty($detailsData)) {
            $product->updateDetails($detailsData);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->image) {
            $this->deleteImage($product->image);
        }
        
        // Delete the product (tags will be automatically detached due to foreign key constraints)
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح!');
    }
}
