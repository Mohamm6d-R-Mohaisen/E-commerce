<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'website_url',
        'description',
        'status',
        'sort_order'
    ];

    /**
     * Scope: Get only active brands
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Order by sort order
     */
    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Relationship: Brand has many products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Accessor: Get formatted logo URL
     */
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return asset('frontend/assets/images/brands/brand-default.png');
        }
        
        if (Str::startsWith($this->logo, ['http', 'https'])) {
            return $this->logo;
        }
        
        return asset('uploads/brands/' . $this->logo);
    }

    /**
     * Accessor: Get formatted website URL
     */
    public function getWebsiteUrlFormattedAttribute()
    {
        if (!$this->website_url) {
            return null;
        }
        
        // Add https if no protocol specified
        if (!Str::startsWith($this->website_url, ['http://', 'https://'])) {
            return 'https://' . $this->website_url;
        }
        
        return $this->website_url;
    }

    /**
     * Mutator: Auto-generate slug from name
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        
        if (!$this->slug) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Mutator: Auto-generate sort order if not provided
     */
    public function setSortOrderAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['sort_order'] = self::max('sort_order') + 1;
        } else {
            $this->attributes['sort_order'] = $value;
        }
    }

    /**
     * Get route key name for model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
