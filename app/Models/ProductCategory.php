<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    // (1) Explicitly point to the existing table:
    protected $connection = 'legacy';
    protected $table = 'product_categories';

    // (2) If your primary key is 'id' and is auto-incrementing, you can leave these as is.
    protected $primaryKey = 'id';
    public $incrementing = true;

    // (3) Allow mass assignment on 'name', 'description', etc.
    protected $fillable = [
        'name',
        'type',
        'description',
        'color',
        // ...any other fillable columns
    ];

    // (4) Define the hasMany relationship → ProductGroup
    public function groups()
    {
        return $this->hasMany(ProductGroup::class, 'category_id', 'id');
    }
}
