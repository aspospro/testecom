<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $connection = 'legacy';
    protected $table = 'product_prices';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];

    // If you ever need back‐reference:
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
