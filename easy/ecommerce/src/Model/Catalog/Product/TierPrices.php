<?php

namespace Easy\Ecommerce\Model\Catalog\Product;

use Easy\Ecommerce\Model\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Easy\Ecommerce\Model\Customer\Group;

class TierPrices extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_tier_prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'special_price',
        'offer_start',
        'offer_end',
        'product_id',
        'customer_group_id'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function customerGroup(): BelongsTo {
        return $this->belongsTo(Group::class, 'customer_group_id', 'id');
    }
}
