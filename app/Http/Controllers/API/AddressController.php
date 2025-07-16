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

        return response()->json($address);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'street_address_line1' => 'required|string|max:255',
            'town_city'            => 'required|string|max:255',
            'county'               => 'nullable|string|max:255',
            'postcode'             => 'required|string|max:20',
            'phone'                => 'required|string|max:20',
        ]);

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

        return response()->json(['message' => 'Address updated', 'address' => $address]);
    }
}
