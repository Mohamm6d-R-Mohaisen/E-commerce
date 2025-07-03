<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    public $incrementing=false;
    protected $table="carts";
    protected $fillable=[
        'cookie_id','user_id','product_id','quantity','option'
    ];
    protected $guarded = [];
    
    protected static function booted()
    {
        static::creating(function (Cart $cart) {
            $cart->id = Str::uuid();
            if (!$cart->cookie_id) {
                $cart->cookie_id = Cart::getCookieId();
            }
        });
    
        static::addGlobalScope('cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', '=', Cart::getCookieId());
        });
    }
    
    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 60 * 24);
        }
        return $cookie_id;
    }
    
    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'Anonymous',
        ]);
    }
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
