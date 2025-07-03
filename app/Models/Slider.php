<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Slider extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'price',
        'button_text',
        'button_link',
        'background_image',
        'status',
        'sort_order'
    ];

    /**
     * Scope: Get only active sliders
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
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Accessor: Get formatted background image URL
     */
    public function getBackgroundImageUrlAttribute()
    {
        if (!$this->background_image) {
            return asset('frontend/assets/images/hero/hero-bg-default.jpg');
        }
        
        if (Str::startsWith($this->background_image, ['http', 'https'])) {
            return $this->background_image;
        }
        
        return asset('uploads/sliders/' . $this->background_image);
    }

    /**
     * Accessor: Get formatted button link
     */
    public function getButtonLinkUrlAttribute()
    {
        if (!$this->button_link) {
            return route('products.index');
        }
        
        // If it's already a full URL, return as is
        if (Str::startsWith($this->button_link, ['http', 'https', '/'])) {
            return $this->button_link;
        }
        
        // Otherwise, assume it's a route name
        try {
            return route($this->button_link);
        } catch (\Exception $e) {
            return route('products.index');
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
}
