<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'reason', 'entry_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
