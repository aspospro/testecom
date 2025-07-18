<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Validation\Rule;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return \App\Models\CartItem::with(['product.price'])
        ->where('user_id', $request->user()->id)
        ->get();
    }

    public function store(Request $request)
{
    $request->validate([
        'product_id' => [
            'required',
            Rule::exists('legacy.products', 'id')
        ],
        'quantity' => 'required|integer|min:1',
    ]);

    $cartItem = CartItem::where('user_id', $request->user()->id)
        ->where('product_id', $request->product_id)
        ->first();

    if ($cartItem) {
        $cartItem->quantity += $request->quantity;
        $cartItem->save();
    } else {
        $cartItem = CartItem::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);
    }

    return response()->json(['message' => 'Added to cart', 'item' => $cartItem]);
}

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Updated', 'item' => $cartItem]);
    }

    public function destroy(Request $request, $id)
    {
        $cartItem = CartItem::where('user_id', $request->user()->id)->findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Removed']);
    }
}
