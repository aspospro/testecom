<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $table = 'delivery_address';
     protected $fillable = [
        'address_id ',
        'first_name',
        'last_name',
        'company',
        'street_address_line1',
        'street_address_line2',
        'town_city',
        'county',
        'postcode',
        'order_notes',
    ];

    public function address()
    {
        return $this->belongsTo(User::class);
    }
}
