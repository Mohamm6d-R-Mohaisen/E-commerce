<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    
    protected $fillable = [
        'name',
        'slug',
        'admin_id',
        'description',
        'price',
        'quantity',
        'image',
        'category_id',
        'store_id',
        'compare_price',
        'status',
        'tags',
        'featured'
    ];

    /**
     * Relationship: Product belongs to a category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Relationship: Product belongs to an admin
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Relationship: Product has many tags (many-to-many)
     */
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'product_tag', 'product_id', 'tag_id');
    }

    /**
     * Relationship: Product has one product details
     */
    public function details()
    {
        return $this->hasOne(ProductDetails::class, 'product_id', 'id');
    }

    /**
     * Scope: Get only active products
     */
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

    /**
     * Accessor: Get formatted image URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
          return '';
      }
        
        if (Str::startsWith($this->image, ['http', 'https'])) {
          return $this->image;
      }
      
      $imageUrl = '';
        
      // Check if the image path already starts with / (absolute path from SaveImageTrait)
        if (Str::startsWith($this->image, ['/'])) {
          $imageUrl = asset($this->image);
      } else {
          $imageUrl = asset('uploads/store/products/' . $this->image);
      }
      
      // Add cache busting parameter to force browser to reload updated images
      $timestamp = $this->updated_at ? $this->updated_at->timestamp : time();
      return $imageUrl . '?v=' . $timestamp;
    }

    /**
     * Accessor: Calculate sale percentage
     */
    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        
        return number_format(100 - (100 * $this->price / $this->compare_price), 0);
    }

    /**
     * Accessor: Get product colors from details
     */
    public function getColorsAttribute()
    {
        return $this->details?->colors ?? [];
    }

    /**
     * Accessor: Get product features from details
     */
    public function getFeaturesAttribute()
    {
        return $this->details?->features ?? [];
    }

    /**
     * Accessor: Get product specifications from details
     */
    public function getSpecificationsAttribute()
    {
        return $this->details?->specifications ?? [];
    }

    /**
     * Accessor: Get product variants from details
     */
    public function getVariantsAttribute()
    {
        return $this->details?->variants ?? [];
    }

    /**
     * Accessor: Get shipping options from details
     */
    public function getShippingOptionsAttribute()
    {
        return $this->details?->shipping_options ?? [];
    }

    /**
     * Relationship: Product belongs to a brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    /**
     * Relationship: Product has one active special offer
     */
    public function special_offer()
    {
        return $this->hasOne(SpecialOffer::class, 'product_id', 'id')
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Relationship: Product has many special offers
     */
    public function specialOffers()
    {
        return $this->hasMany(SpecialOffer::class, 'product_id', 'id');
    }

    /**
     * Relationship: Product has current special offer
     */
    public function currentSpecialOffer()
    {
        return $this->hasOne(SpecialOffer::class, 'product_id', 'id')->current();
    }

    /**
     * Accessor: Get current special offer price
     */
    public function getSpecialPriceAttribute()
    {
        $offer = $this->currentSpecialOffer;
        return $offer ? $offer->discounted_price : null;
    }

    /**
     * Accessor: Check if product has special offer
     */
    public function getHasSpecialOfferAttribute()
    {
        return $this->currentSpecialOffer !== null;
    }

    /**
     * Create or update product details
     */
    public function updateDetails(array $detailsData)
    {
        if ($this->details) {
            $this->details->update($detailsData);
        } else {
            $this->details()->create($detailsData);
        }
        
        return $this->details;
    }
}
