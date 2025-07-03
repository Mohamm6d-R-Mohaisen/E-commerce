<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class SpecialOffer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'title',
        'description',
        'discount_percentage',
        'special_price',
        'start_date',
        'end_date',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'discount_percentage' => 'decimal:2',
        'special_price' => 'decimal:2'
    ];

    /**
     * Relationship: SpecialOffer belongs to a product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope: Get only active offers
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Get current active offers (within date range)
     */
    public function scopeCurrent(Builder $query)
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now)
                    ->where('status', 'active');
    }

    /**
     * Scope: Order by sort order
     */
    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('end_date', 'asc');
    }

    /**
     * Accessor: Check if offer is currently active
     */
    public function getIsActiveAttribute()
    {
        if ($this->status !== 'active') {
            return false;
        }
        
        $now = Carbon::now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    /**
     * Accessor: Check if offer has expired
     */
    public function getIsExpiredAttribute()
    {
        return $this->end_date < Carbon::now();
    }

    /**
     * Accessor: Get days remaining
     */
    public function getDaysRemainingAttribute()
    {
        if ($this->is_expired) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($this->end_date, false);
    }

    /**
     * Accessor: Get hours remaining
     */
    public function getHoursRemainingAttribute()
    {
        if ($this->is_expired) {
            return 0;
        }
        
        return Carbon::now()->diffInHours($this->end_date, false) % 24;
    }

    /**
     * Accessor: Get minutes remaining
     */
    public function getMinutesRemainingAttribute()
    {
        if ($this->is_expired) {
            return 0;
        }
        
        return Carbon::now()->diffInMinutes($this->end_date, false) % 60;
    }

    /**
     * Accessor: Get seconds remaining
     */
    public function getSecondsRemainingAttribute()
    {
        if ($this->is_expired) {
            return 0;
        }
        
        return Carbon::now()->diffInSeconds($this->end_date, false) % 60;
    }

    /**
     * Accessor: Calculate discounted price
     */
    public function getDiscountedPriceAttribute()
    {
        if ($this->special_price) {
            return $this->special_price;
        }
        
        if ($this->discount_percentage && $this->product) {
            $discount = ($this->product->price * $this->discount_percentage) / 100;
            return $this->product->price - $discount;
        }
        
        return $this->product?->price ?? 0;
    }

    /**
     * Accessor: Get savings amount
     */
    public function getSavingsAmountAttribute()
    {
        if (!$this->product) {
            return 0;
        }
        
        return $this->product->price - $this->discounted_price;
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
     * Boot method to handle automatic status updates
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($offer) {
            // Auto-update status based on dates
            if ($offer->end_date < Carbon::now()) {
                $offer->status = 'expired';
            }
        });
    }
}
