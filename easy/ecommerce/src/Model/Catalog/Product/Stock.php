<?php

namespace Easy\Ecommerce\Model\Catalog\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Easy\Ecommerce\Model\Catalog\Product as CatalogProduct;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['quantity','reserved_quantity','product_id','inventory_id'];

    /**
    * Get the product that owns the inventory.
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(CatalogProduct::class, 'product_id', 'id');
    }

    /**
     * Get the source that owns the inventory.
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}
