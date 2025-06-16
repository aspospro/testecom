<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1) Validate incoming request
        $data = $request->validate([
          'items'          => 'required|array|min:1',
          'items.*.product_id' => 'required|exists:products,id',
          'items.*.qty'        => 'required|integer|min:1',
          'shipping.address'   => 'required|string|max:255',
          'shipping.city'      => 'required|string|max:100',
          'shipping.postcode'  => 'required|string|max:20',
        ]);

        // Wrap in DB transaction
        $order = DB::transaction(function() use ($data) {
            // 2) Create the Order
            $order = Order::create([
                'user_id'      => auth()->id(),              // null if guest
                'total_amount' => 0,                         // we'll update it
                'status'       => 'pending',
                'address'      => $data['shipping']['address'],
                'city'         => $data['shipping']['city'],
                'postcode'     => $data['shipping']['postcode'],
            ]);

            $total = 0;

            // 3) Loop items -> create OrderItem & decrement stock
            foreach ($data['items'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);
                
                // calculate line total
                $unitPrice = $product->price;
                $lineTotal = $unitPrice * $item['qty'];
                $total += $lineTotal;

                // optionally decrement stock
                // $product->decrement('stock', $item['qty']);

                // snapshot each line
                $order->items()->create([
                  'product_id'   => $product->id,
                  'quantity'     => $item['qty'],
                  'unit_price'   => $unitPrice,
                  'product_name' => $product->name,
                ]);
            }

            // 4) Update order total
            $order->update(['total_amount' => $total]);

            return $order;
        });

        // 5) Return JSON confirmation
        return response()->json([
           'order_id' => $order->id,
           'status'   => $order->status,
           'total'    => number_format($order->total_amount, 2),
        ], 201);
    }
}

