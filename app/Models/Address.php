<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

     protected $table = 'address';
     protected $fillable = [
        'user_id',
        'street_address_line1',
        'street_address_line2',
        'town_city',
        'county',
        'postcode',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
