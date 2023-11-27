<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasRelationships;

    protected $fillable = [
        'total',
        'status',
        'payment_url',
        'shipment_address',
        'tracking_number',
        'region_code',
        'user_id',
        'seller_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_orders')
            ->withPivot('quantity');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
