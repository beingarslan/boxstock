<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\Product;

class ProductManageController extends Controller
{
    public function productFilter(Request $request)
    {
        $price      = $request->price;
        $category   = $request->category;
        $brand   = $request->brand;
        $search   = $request->search;

        $query = Product::with('category');

        if ($price) {
            $priceArr = explode('-', $price);
            $query->whereBetween('amount', [$priceArr[0], $priceArr[1]]);
        }

        if ($category) {
            $query->where('category_id', '=', $category);
        }

        if ($brand) {
            $query->where('brand_id', '=', $brand);
        }

        if($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $products = $query->get();

        return response()->json([
            'status'  =>  200,
            'products'=> $products,
        ]);
    }

    public function productFilterSearch(Request $request)
    {
//        dd($request->search);
        $search   = $request->search;
        if($search) {
            $query = Product::with('category');
            $query->where('name', 'LIKE', "%{$search}%");
            $products = $query->get();
            return response()->json([
                'status'  =>  200,
                'products'=> $products,
            ]);
        } else {
            return response()->json([
                'status'  =>  200,
                'products'=> [],
            ]);
        }
    }

    public function getProductBySlug(Request $request) {
        $slug      = $request->slug;
        $product = Product::where('slug', $slug)->first();
        $variations = Variant::with('size')->where('product_id', $product->id)->get();
        return response()->json([
            'status'  =>  200,
            'product'=> $product,
            'variations'=>$variations
        ]);
    }

    public function getProductByType(Request $request) {
        $type   = $request->type;
        $query = Product::with('category');
        $query->where('product_type', '=', $type);
        $products = $query->get();
        return response()->json([
            'status'  =>  200,
            'products'=> $products,
        ]);
    }
}
