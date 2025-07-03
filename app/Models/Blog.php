<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'author',
        'tags',
        'status',
        'featured',
        'views',
        'sort_order',
        'published_at',
        'admin_id'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'views' => 'integer',
        'sort_order' => 'integer',
        'published_at' => 'datetime'
    ];

    /**
     * Relationship: Blog belongs to an admin
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Scope: Get only active blogs
     */
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

    /**
     * Scope: Get only published blogs
     */
    public function scopePublished(Builder $builder)
    {
        $builder->whereNotNull('published_at')
                ->where('published_at', '<=', now());
    }

    /**
     * Scope: Get only featured blogs
     */
    public function scopeFeatured(Builder $builder)
    {
        $builder->where('featured', true);
    }

    /**
     * Scope: Get blogs by category
     */
    public function scopeByCategory(Builder $builder, $category)
    {
        if ($category) {
            $builder->where('category', $category);
        }
    }

    /**
     * Accessor: Get formatted featured image URL
     */
    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return 'https://via.placeholder.com/370x215';
        }
        
        if (Str::startsWith($this->featured_image, ['http', 'https'])) {
            return $this->featured_image;
        }
        
        // Check if the image path already starts with / (absolute path)
        if (Str::startsWith($this->featured_image, ['/'])) {
            return asset($this->featured_image);
        } else {
            return asset('uploads/blogs/' . $this->featured_image);
        }
    }

    /**
     * Accessor: Get reading time estimate
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingSpeed = 200; // Average words per minute
        $minutes = ceil($wordCount / $readingSpeed);
        
        return $minutes . ' min read';
    }

    /**
     * Accessor: Get formatted published date
     */
    public function getPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : null;
    }

    /**
     * Accessor: Get excerpt or truncated content
     */
    public function getExcerptOrContentAttribute()
    {
        return $this->excerpt ?: Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Accessor: Get tags as array
     */
    public function getTagsArrayAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    /**
     * Mutator: Auto-generate slug from title
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        
        if (!$this->slug) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Mutator: Set published_at if not set and status is active
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        
        if ($value === 'active' && !$this->published_at) {
            $this->attributes['published_at'] = now();
        }
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get related blogs by category
     */
    public function getRelatedBlogs($limit = 3)
    {
        return static::active()
            ->published()
            ->where('category', $this->category)
            ->where('id', '!=', $this->id)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
