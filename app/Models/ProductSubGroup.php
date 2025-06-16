<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSubGroup extends Model
{
    use SoftDeletes;

    // (1) Point to the existing table:
    protected $connection = 'legacy';
    protected $table = 'product_sub_groups';

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'group_id',
        'name',
        'type',
        'description',
        'is_manually_set',
        // ...any other fillable columns
    ];

    // (2) A subgroup belongsTo a group:
    public function group()
    {
        return $this->belongsTo(ProductGroup::class, 'group_id', 'id');
    }
}
