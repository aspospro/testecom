<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductListingController extends Controller
{
    public function byCategory($categoryId)
    {
        $perPage = request()->get('per_page', 20);
        $products = Product::join('product_categorizations as pc', 'products.id', '=', 'pc.product_id')
            ->with('price')
            ->where('pc.category_id', $categoryId)
            ->where('products.is_sell_online', 1)
            ->select('products.*')
            ->paginate($perPage);;

        return response()->json($products);
    }

    public function byGroup($categoryId, $groupId)
    {
        $perPage = request()->get('per_page', 20);
        $products = Product::join('product_categorizations as pc', 'products.id', '=', 'pc.product_id')
            ->with('price')
            ->where('pc.category_id', $categoryId)
            ->where('pc.group_id', $groupId)
            ->where('products.is_sell_online', 1)
            ->select('products.*')
            ->paginate($perPage);;

        return response()->json($products);
    }

    public function bySubgroup($categoryId, $groupId, $subgroupId)
    {
        $perPage = request()->get('per_page', 20);
        $products = Product::join('product_categorizations as pc', 'products.id', '=', 'pc.product_id')
            ->with('price')
            ->where('pc.category_id', $categoryId)
            ->where('pc.group_id', $groupId)
            ->where('pc.sub_group_id', $subgroupId)
            ->where('products.is_sell_online', 1)
            ->select('products.*')
            ->paginate($perPage);;

        return response()->json($products);
    }
}
