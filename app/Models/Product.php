<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'price_vat',
        'price_ttc',
        'name',
        'description',
        'stock',
        'focus',
        'place',
        'rank',
        'picture'
    ];

    public function picture(){
        return $this->hasMany(Picture::class);

    }
}
