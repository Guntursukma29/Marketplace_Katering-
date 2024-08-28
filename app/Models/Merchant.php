<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'contact',
        'description',
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Menu model
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Relationship with Order model
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
