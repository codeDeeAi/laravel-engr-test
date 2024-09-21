<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasOne, HasMany};

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hmo_code',
        'provider',
        'encounter_date',
        'total_items_cost',
    ];

    /**
     * Get the hmo associated with the Order
     *
     * @return HasOne
     */
    public function hmo(): HasOne
    {
        return $this->hasOne(Hmo::class, 'code', 'hmo_code');
    }

    /**
     * Get all of the items for the Order
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
