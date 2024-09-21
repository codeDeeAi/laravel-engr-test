<?php

namespace App\Models;

use App\Enums\MonthEnum;
use App\Enums\BatchRuleEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasManyThrough};

class Batch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hmo_id',
        'order_id',
        'identifier',
        'batch_rule',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'batch_rule' => BatchRuleEnum::class,
        ];
    }

    /**
     * Get the hmo that owns the Batch
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }

    /**
     * Get all of the orders for the Batch
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, BatchOrder::class)->with('items');
    }
}
