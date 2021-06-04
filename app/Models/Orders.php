<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 */
class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_vat',
        'amount_ttc',
        'done'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);

    }
}
