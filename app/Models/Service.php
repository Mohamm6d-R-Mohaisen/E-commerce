<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Service extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'icon',
        'status',
        'sort_order'
    ];

    /**
     * Scope: Get only active services
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