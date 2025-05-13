<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="string", example="1"),
 *         @OA\Property(property="name", type="string", example="Laptop"),
 *         @OA\Property(property="category_id", type="string", example="1"),
 *         @OA\Property(property="price", type="number", format="float", example=1500.00),
 *         @OA\Property(property="stock", type="integer", example=100),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T12:00:00Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-02T12:00:00Z")
 *     }
 * )
 */


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

            $product->quantity = 0;
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
