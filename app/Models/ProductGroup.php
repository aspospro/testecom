<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends Model
{
    use SoftDeletes;

    // (1) Point to the existing table:
    protected $connection = 'legacy';
    protected $table = 'product_groups';

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'category_id',
        'name',
        'type',
        'description',
        'is_manually_set',
        // ...any other fillable columns
    ];

    // (2) A group belongsTo a category:
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    // (3) A group hasMany subgroups:
    public function subgroups()
    {
        return $this->hasMany(ProductSubGroup::class, 'group_id', 'id');
    }
}
