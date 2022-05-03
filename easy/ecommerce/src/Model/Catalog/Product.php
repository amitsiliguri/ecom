<?php

namespace Easy\Ecommerce\Model\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Easy\Ecommerce\Model\Catalog\Product\Image;
use Easy\Ecommerce\Model\Catalog\Product\Price;
use Easy\Ecommerce\Model\Catalog\Product\TierPrices;
//use Easy\Ecommerce\Model\Catalog\Product\Stock;
use Easy\Ecommerce\Model\Catalog\Product\Inventory;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'sku',
        'title',
        'small_description',
        'description',
        'type',
        'maintain_stock',
        'slug',
        'meta_title',
        'meta_description',
        'meta_image'
    ];

    /**
     * @return hasOne
     */
    public function price(): HasOne
    {
        return $this->hasOne(
            Price::class,
            'product_id',
            'id'
        );
    }

    /**
     * @return HasMany
     */
    public function tierPrice(): HasMany
    {
        return $this->hasMany(
            TierPrices::class,
            'product_id',
            'id'
        );
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(
            Image::class,
            'product_id',
            'id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function inventories(): BelongsToMany
    {
        return $this->belongsToMany(
            Inventory::class,
            'stocks',
            'product_id',
            'inventory_id'
        )->withPivot(['quantity']);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'category_products',
            'product_id',
            'category_id'
        );
    }
}
