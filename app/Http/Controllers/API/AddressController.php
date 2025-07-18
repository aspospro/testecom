<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function show(Request $request)
{
    $user = $request->user();
    $address = Address::where('user_id', $user->id)->first();

    return response()->json([
        'address' => $address,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'company' => $user->company,
    ]);
}

public function update(Request $request)
{
    $user = $request->user();

    $request->validate([
        'first_name'            => 'required|string|max:255',
        'last_name'             => 'required|string|max:255',
        'company'               => 'nullable|string|max:255',
        'street_address_line1'  => 'required|string|max:255',
        'street_address_line2'  => 'nullable|string|max:255',
        'town_city'             => 'required|string|max:255',
        'county'                => 'nullable|string|max:255',
        'postcode'              => 'required|string|max:20',
        'phone'                 => 'required|string|max:20',
    ]);

    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->company = $request->company;
    $user->save();

    $address = Address::updateOrCreate(
        ['user_id' => $user->id],
        $request->only([
            'street_address_line1',
            'street_address_line2',
            'town_city',
            'county',
            'postcode',
            'phone',
        ])
    );

    return response()->json([
        'message' => 'Address and user info updated',
        'address' => $address,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'company' => $user->company,
    ]);
}
}
