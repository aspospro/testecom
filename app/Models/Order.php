<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'user_id','total_amount','status',
      'address','city','postcode'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

