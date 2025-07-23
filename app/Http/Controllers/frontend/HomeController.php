<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\SpecialOffer;
use App\Models\Blog;
use App\Models\About;
use App\Models\Team;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactMessageMail;
use App\Http\Requests\ContactRequest;

class HomeController extends Controller
{
    /**
     * Display the homepage with all dynamic content
     */
    public function index()
    {
        // Get active sliders ordered by sort_order
        $sliders = Slider::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get active banners ordered by sort_order  
        $banners = Banner::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();

        // Get active categories with products count
        $categories = Category::where('status', 'active')
            ->withCount('products')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get featured/trending products
        $featuredProducts = Product::with('category')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Get active special offers
        $specialOffers = SpecialOffer::with('product.category')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        // Debug
        Log::info('Special Offers Count: ' . $specialOffers->count());

        // Filter active offers in PHP
        $specialOffers = $specialOffers->filter(function($offer) {
            return $offer->product 
                && $offer->product->status === 'active'
                && $offer->start_date <= now()
                && $offer->end_date >= now();
        });

        // Get active brands
        $brands = Brand::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Get best selling products (you can modify this logic)
        $bestSellers = Product::with('category')
            ->where('status', 'active')
            ->orderBy('created_at', 'asc') // Oldest products as "best sellers"
            ->limit(3)
            ->get();

        // Get newest products
        $newArrivals = Product::with('category')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get latest blogs
        $latestBlogs = Blog::active()
            ->published()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('frontend.shop.home', compact(
            'sliders',
            'banners', 
            'categories',
            'featuredProducts',
            'specialOffers',
            'brands',
            'bestSellers',
            'newArrivals',
            'latestBlogs'
        ));
    }

    /**
     * Display all products with filters
     */
    public function products(Request $request)
    {
        $query = Product::with('category')->active();
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }
        
        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        
        // Sorting
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        
        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortOrder);
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'name':
            default:
                $query->orderBy('name', $sortOrder);
                break;
        }
        
        $products = $query->paginate(12);
        $categories = Category::active()->get();
        
        return view('frontend.shop.products.index', compact('products', 'categories'));
    }

    /**
     * Display a specific product
     */
    public function show(Product $product)
    {
        // Check if product is active
        if ($product->status != 'active') {
                    abort(404);
                }
        
        // Load product details relationship
        $product->load('details', 'category');
        
        return view('frontend.shop.products.show', compact('product'));
    }

    /**
     * Display About Us page
     */
    public function about()
    {
        // Get active categories for header navigation
        $headerCategories = Category::where('status', 'active')
            ->withCount('products')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get active about content
        $about = \App\Models\About::where('is_active', true)
            ->latest()
            ->first();
        
        // Get active team members ordered by sort_order
        $teamMembers = \App\Models\Team::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('frontend.about', compact('headerCategories', 'about', 'teamMembers'));
    }

    /**
     * Display Contact Us page
     */
    public function contact()
    {
        // Get active categories for header navigation
        $headerCategories = Category::where('status', 'active')
            ->withCount('products')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('frontend.contact', compact('headerCategories'));
    }

    /**
     * Store a contact message
     */
    public function storeContact(ContactRequest $request)
    {
        try {
            // Create contact record
            $contact = Contact::create([
                'name' => $request->validated()['name'],
                'email' => $request->validated()['email'],
                'phone' => $request->validated()['phone'],
                'subject' => $request->validated()['subject'],
                'message' => $request->validated()['message'],
                'is_read' => false,
            ]);

            // Send notification email to admin (uncomment and configure email)
            // Mail::to('admin@yoursite.com')->send(new ContactMessageMail($contact));

            return redirect()->back()->with('success', __('app.message_sent_success'));
            
        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', __('app.message_send_error'))
                ->withInput();
        }
    }
}
