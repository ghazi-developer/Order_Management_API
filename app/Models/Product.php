<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Product extends Model
{
    use HasFactory,HasRoles,HasApiTokens;

     // Fillable attributes for mass assignment
     protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'status', // 'pending', 'approved', or 'sold'
        'seller_id', // Foreign key to the seller user
    ];

    /**
     * Relationship with the User (Seller)
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Relationship with the Order (this product can have many orders)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
