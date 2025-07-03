<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'subtitle',
        'price',
        'background_image',
        'link',
        'type',
        'position',
        'status',
        'sort_order'
    ];

    /**
     * Available banner types
     */
    const TYPES = [
        'small_banner_1' => 'Small Banner 1',
        'small_banner_2' => 'Small Banner 2', 
        'weekly_sale' => 'Weekly Sale',
        'main_banner' => 'Main Banner'
    ];

    /**
     * Available positions
     */
    const POSITIONS = [
        'left' => 'Left',
        'right' => 'Right',
        'center' => 'Center',
        'full' => 'Full Width'
    ];

    /**
     * Scope: Get only active banners
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Filter by type
     */
    public function scopeOfType(Builder $query, $type)
    {
        return $query->where('type', $type);
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
            return asset('frontend/assets/images/banners/banner-default.jpg');
        }
        
        if (Str::startsWith($this->background_image, ['http', 'https'])) {
            return $this->background_image;
        }
        
        return asset('uploads/banners/' . $this->background_image);
    }

    /**
     * Accessor: Get formatted link URL
     */
    public function getFormattedLinkAttribute()
    {
        if (!$this->link) {
            return '#';
        }
        
        // If it's already a full URL, return as is
        if (Str::startsWith($this->link, ['http', 'https', '/'])) {
            return $this->link;
        }
        
        // Otherwise, assume it's a route name
        try {
            return route($this->link);
        } catch (\Exception $e) {
            return '#';
        }
    }

    /**
     * Accessor: Get type label
     */
    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * Accessor: Get position label
     */
    public function getPositionLabelAttribute()
    {
        return self::POSITIONS[$this->position] ?? $this->position;
    }

    /**
     * Mutator: Auto-generate sort order if not provided
     */
    public function setSortOrderAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['sort_order'] = self::where('type', $this->type)->max('sort_order') + 1;
        } else {
            $this->attributes['sort_order'] = $value;
        }
    }
}
