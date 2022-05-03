<?php

namespace Easy\Ecommerce\Model\Catalog\Product;

use Easy\Ecommerce\Model\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Price extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_price';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'base_price',
        'special_price',
        'offer_start',
        'offer_end',
        'product_id'
    ];

    /**
     * Get the product that owns the price.
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'product_id', 'id');
    }
}
