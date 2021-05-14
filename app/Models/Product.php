<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail()
 * @method static create(array $productData)
 * @method static find(int $id)
 */
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
