<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name', 'category_id','price'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product){
            $lastId = Product::orderBy('id', 'desc')->first();
            if ($lastId) {
                $product->id = str_pad(((int)$lastId->id) + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $product->id = '8100';
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
