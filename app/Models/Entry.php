<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Entry",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="string", example="1"),
 *         @OA\Property(property="product_id", type="string", example="1"),
 *         @OA\Property(property="quantity", type="integer", example=50),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T12:00:00Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-02T12:00:00Z")
 *     }
 * )
 */

class Entry extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'reason', 'entry_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
