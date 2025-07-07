<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use the “legacy” connection
    protected $connection = 'legacy';

    // if your primary key is “id” (unsigned bigint), you can skip these,
    // but it’s good to be explicit
    protected $table = 'products';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Only allow reading—no mass‐assignment needed for display
    protected $guarded = [];

    // If you only want “online” items, you can filter later,
    // but let’s define a scope for convenience:
    public function scopeOnline($query)
    {
        return $query->where('is_sell_online', 1)->where('status', 1);
    }

    // Relation: each product has one “current” price in product_prices
    public function price()
    {
        return $this
            ->hasOne(ProductPrice::class, 'product_id', 'id')
            ->select(['product_id', 'base_price']);  // ← only pull back the FK + base_price
    }
}
