<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Order extends Model
{
    use HasFactory,HasRoles,HasApiTokens;
    

    // Fillable attributes for mass assignment
    protected $fillable = [
        'product_id',
        'client_id',
        'status', // 'pending', 'delivered'
    ];

    /**
     * Relationship with the Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship with the User (Client)
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
