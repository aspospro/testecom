<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Return all “online” products plus their price.
     */
    public function index()
    {
        // Eager‐load the “price” relation. We defined price() in Product.
        $products = Product::online()
            ->with(['price' => function($q) {
                // Only select base_price (and product_id if you like)
                $q->select('product_id', 'base_price');
            }])
            ->get(['id', 'short_description', 'description', 'image_url','product_code']);

        // Transform into a simpler array, merging price:
        $result = $products->map(function($p) {
            return [
                'id'                => $p->id,
                'name'              => $p->short_description ?: $p->description,
                'image_url'         => $p->image_url, 
                'code'              => $p->product_code, 
                // We assume image_url stores a full URL or path; handle nulls in React.
                'base_price'        => optional($p->price)->base_price ?? 0,
            ];
        });

        return response()->json($result);
    }

    public function show($id)
    {
        // Grab exactly one product or throw a 404
        $product = Product::online()
            ->with(['price' => function ($q) {
                $q->select('product_id', 'base_price');
            }])
            ->findOrFail($id, [
                'id',
                'short_description',
                'description',
                'image_url',
                'product_code'
            ]);

        // Shape it into the payload you want
        $result = [
            'id'         => $product->id,
            'name'       => $product->short_description ?: $product->description,
            'image_url'  => $product->image_url,
            'code'       => $product->product_code,
            'base_price' => optional($product->price)->base_price ?? 0,
        ];

        return response()->json($result);
    }
}
