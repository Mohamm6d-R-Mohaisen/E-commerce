<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    use HasFactory;
    
    protected $table = 'product_details';
    
    protected $fillable = [
        'product_id',
        'colors',
        'variants',
        'features',
        'specifications',
        'shipping_options',
        'gallery_images',
        'videos',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'long_description',
        'dimensions',
        'weight',
        'weight_unit',
        'sku',
        'barcode',
        'warranty_period',
        'warranty_details',
        'support_documents'
    ];

    /**
     * Cast attributes to appropriate types
     */
    protected $casts = [
        'colors' => 'array',
        'variants' => 'array',
        'features' => 'array',
        'specifications' => 'array',
        'shipping_options' => 'array',
        'gallery_images' => 'array',
        'videos' => 'array',
        'dimensions' => 'array',
        'support_documents' => 'array',
        'weight' => 'decimal:2'
    ];

    /**
     * Relationship: ProductDetails belongs to a Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Accessor: Get formatted weight with unit
     */
    public function getFormattedWeightAttribute()
    {
        if (!$this->weight) {
            return null;
        }
        
        return $this->weight . ' ' . $this->weight_unit;
    }

    /**
     * Accessor: Get primary color (first color in array)
     */
    public function getPrimaryColorAttribute()
    {
        if (!$this->colors || empty($this->colors)) {
            return null;
        }
        
        return $this->colors[0] ?? null;
    }

    /**
     * Accessor: Get available colors only
     */
    public function getAvailableColorsAttribute()
    {
        if (!$this->colors) {
            return [];
        }
        
        return array_filter($this->colors, function($color) {
            return isset($color['available']) && $color['available'] === true;
        });
    }

    /**
     * Accessor: Get features as formatted list
     */
    public function getFormattedFeaturesAttribute()
    {
        if (!$this->features || empty($this->features)) {
            return [];
        }
        
        return $this->features;
    }

    /**
     * Accessor: Get specifications as key-value pairs
     */
    public function getFormattedSpecificationsAttribute()
    {
        if (!$this->specifications) {
            return [];
        }
        
        return $this->specifications;
    }

    /**
     * Accessor: Get shipping options with formatted prices
     */
    public function getFormattedShippingOptionsAttribute()
    {
        if (!$this->shipping_options) {
            return [];
        }
        
        return array_map(function($option) {
            if (isset($option['price'])) {
                $option['formatted_price'] = '$' . number_format($option['price'], 2);
            }
            return $option;
        }, $this->shipping_options);
    }

    /**
     * Accessor: Get gallery images with full URLs
     */
    public function getGalleryImageUrlsAttribute()
    {
        if (!$this->gallery_images) {
            return [];
        }
        
        return array_map(function($image) {
            if (str_starts_with($image, 'http')) {
                return $image;
            }
            return asset('uploads/store/products/gallery/' . $image);
        }, $this->gallery_images);
    }

    /**
     * Mutator: Ensure colors have required structure
     */
    public function setColorsAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        
        // Ensure each color has required keys
        if (is_array($value)) {
            $colors = array_map(function($color) {
                return array_merge([
                    'name' => '',
                    'value' => '#000000',
                    'available' => true
                ], $color);
            }, $value);
            
            $this->attributes['colors'] = json_encode($colors);
        } else {
            $this->attributes['colors'] = null;
        }
    }

    /**
     * Mutator: Ensure variants have required structure
     */
    public function setVariantsAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        
        // Ensure each variant has required keys
        if (is_array($value)) {
            $variants = array_map(function($variant) {
                return array_merge([
                    'type' => '',
                    'label' => '',
                    'options' => []
                ], $variant);
            }, $value);
            
            $this->attributes['variants'] = json_encode($variants);
        } else {
            $this->attributes['variants'] = null;
        }
    }
}
