<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug'];
    public $timestamps = false;
    public function products(){
        return $this->belongsToMany(Product::class,'product_tag','tag_id','product_id');
    }
}
