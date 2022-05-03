<?php

namespace Easy\Ecommerce\Model\Customer;

use Easy\Ecommerce\Model\Catalog\Product\TierPrices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title'
    ];

    /**
     * @return HasMany
     */
    public function tierPrice(): HasMany
    {
        return $this->hasMany(
            TierPrices::class,
            'customer_group_id',
            'id'
        );
    }
}
