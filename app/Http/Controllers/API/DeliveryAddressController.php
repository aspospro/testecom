<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;

class DeliveryAddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = DeliveryAddress::where('user_id', $request->user()->id)->get();
        return response()->json($addresses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'             => 'required|string|max:100',
            'last_name'              => 'required|string|max:100',
            'company'                => 'nullable|string|max:255',
            'street_address_line1'   => 'required|string|max:255',
            'street_address_line2'   => 'nullable|string|max:255',
            'town_city'              => 'required|string|max:255',
            'county'                 => 'nullable|string|max:255',
            'postcode'               => 'required|string|max:20',
            'order_notes'            => 'nullable|string|max:500',
        ]);

        $address = DeliveryAddress::create([
            ...$request->only([
                'first_name', 'last_name', 'company',
                'street_address_line1', 'street_address_line2',
                'town_city', 'county', 'postcode', 'order_notes'
            ]),
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['message' => 'Delivery address added', 'address' => $address]);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $address = DeliveryAddress::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'first_name'             => 'required|string|max:100',
            'last_name'              => 'required|string|max:100',
            'company'                => 'nullable|string|max:255',
            'street_address_line1'   => 'required|string|max:255',
            'street_address_line2'   => 'nullable|string|max:255',
            'town_city'              => 'required|string|max:255',
            'county'                 => 'nullable|string|max:255',
            'postcode'               => 'required|string|max:20',
            'order_notes'            => 'nullable|string|max:500',
        ]);

        $address->update($request->only([
            'first_name', 'last_name', 'company',
            'street_address_line1', 'street_address_line2',
            'town_city', 'county', 'postcode', 'order_notes'
        ]));

        return response()->json(['message' => 'Delivery address updated', 'address' => $address]);
    }
    
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $address = DeliveryAddress::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $address->delete();

        return response()->json(['message' => 'Delivery address deleted']);
    }
}
