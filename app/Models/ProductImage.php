<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory, HasRelationships;

    protected $fillable = [
        'image_url',
        'product_id',
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
