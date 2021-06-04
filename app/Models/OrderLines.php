<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLines extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_vat',
        'stock',
        'done',
    ];

    public function orders(){
        return $this->hasMany(Orders::class);
    }

    public function products(){
        return $this->hasOne(Product::class);
    }

}
