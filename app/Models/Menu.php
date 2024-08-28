<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'price',
        'photo',
    ];

    // Relationship with Merchant model
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Relationship with Order model
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
