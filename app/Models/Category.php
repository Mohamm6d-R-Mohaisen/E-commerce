<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    public $incrementing = true;
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'slug', 
        'status',
        'image',
        'description'
    ];

    /**
     * Relationship: Category has many products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
   
    /**
     * Scope: Get only active categories
     */
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

    /**
     * Scope: Filter categories by name and status
     */
    public function scopeFilters(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('name', 'LIKE', "%{$filters['name']}%");
        }
        
        if ($filters['status'] ?? false) {
            $builder->where('status', $filters['status']);
        }
    }
}
