<?php

namespace Easy\Ecommerce\Model\Catalog\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Easy\Ecommerce\Model\Catalog\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status','title'];

    /**
     * Get the inventories for the product.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'inventory_id', 'id');
    }

    /**
     * The products that belong to the source.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'stocks',
            'inventory_id',
            'product_id'
        )->withPivot(['quantity','reserved_quantity']);
    }
}
