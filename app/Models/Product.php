<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasRelationships;

    protected $fillable = [
        'is_public',
        'name',
        'type',
        'condition',
        'description',
        'price',
        'stock',
        'seller_id',
    ];

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_orders')
            ->withPivot('quantity');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
