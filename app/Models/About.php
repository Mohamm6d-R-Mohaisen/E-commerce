<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\SaveImageTrait;

class About extends Model
{
    use HasFactory, SaveImageTrait;

    protected $fillable = [
        'title',
        'description', 
        'content',
        'image',
        'video_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Scope a query to only include active about.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the image attribute with full URL
     */
    public function getImageAttribute($value)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
            // If the value already starts with /uploads/, return as is
            if (strpos($value, '/uploads/') === 0) {
                return asset($value);
            }
            // Otherwise, assume it's just the filename and add the about path
            return asset('uploads/about/' . $value);
        }
        return $value;
    }
}
