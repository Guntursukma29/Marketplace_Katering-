<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'merchant_id',
        'menu_id',
        'quantity',
        'delivery_date',
        'total_price',
    ];

    // Relationship with Customer model
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relationship with Menu model
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
