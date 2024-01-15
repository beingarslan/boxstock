<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return response()->json([
                'status'=> 400,
                'errors'=> 'Unauthenticated user',
            ]);
        }

        $products = Product::with('category')->get();

        if(isset($_GET['page'])) {
            $data = Product::with('category')->where('product_type', '=', 0)->orderBy('id')->paginate(3);
            return response()->json([
                'status'=> 200,
                'product' => $data,
            ]);
        }

        return response()->json([
            'status'=> 200,
            'product' => $products,
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //dd($request);

        $validator = $request->validate([
            'name'  => 'required|unique:products',
            'amount' => 'required|string'
        ]);

        $user = Auth::user();

        if (!$user->isAdmin()) {
            return response()->json([
                'status'=> 400,
                'errors'=> 'Unauthenticated user',
            ]);
        }

        if($validator->fails())
        {
            return response()->json([
                'status'=> 400,
                'errors'=> $validator->messages(),
            ]);
        }
        else
        {

            if($request->hasFile('image')){

                //get filename with the extension
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                // GET just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                //filename to store
                $user_iamge = $filename.'_'.time().'.'.$extension;
                $request->file('image')->move(public_path('/product'),$user_iamge);
                $fileProductimage = "/product/" . $user_iamge;
            } else {
                $fileProductimage = 'no.png';
            }

            $product                = new Product();
            $product->name          = $request->name;
            $product->slug          = Str::slug($request->name);
//            $product->image         = $fileProductimage;
            if($request->hasFile('image')){
                $product->image         = $fileProductimage;
            }
            $product->des           = $request->des;
            $product->sku           = $request->sku;
            $product->amount        = $request->amount;
            $product->category_id   = $request->category_id;
            $product->brand_id      = $request->brand_id;
            $product->color_id      = $request->color_id;
            $product->size_id       = $request->size_id;
            $product->product_type       = $request->product_type;
            $product->save();

            return response()->json([
                'status' =>  200,
                'message'=> 'Product Created Successfully!',
            ]);
        }
    }


    public function show($id)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return response()->json([
                'status'=> 400,
                'errors'=> 'Unauthenticated user',
            ]);
        }

        $product = Product::find($id);
        if($product)
        {
            return response()->json([
                'status' => 200,
                'product'=> $product,
            ]);
        }
        else
        {
            return response()->josn([
                'status' =>  404,
                'message'=> 'No product found!',
            ]);
        }
    }


    public function edit($id)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return response()->json([
                'status'=> 400,
                'errors'=> 'Unauthenticated user',
            ]);
        }

        $product = Product::find($id);
        if($product)
        {
            return response()->json([
                'status'=>200,
                'product'=>$product,
            ]);
        }
        else
        {
            return response()->josn([
                'status'=>404,
                'message'=>'No product found!',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
//        dd($request);
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return response()->json([
                'status'=> 400,
                'errors'=> 'Unauthenticated user',
            ]);
        }

        if($request->hasFile('image')){
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $user_iamge = $filename.'_'.time().'.'.$extension;
            $request->file('image')->move(public_path('/product'),$user_iamge);
            $fileProductimage = "/product/" . $user_iamge;
        } else {
            $fileProductimage = 'no.png';
        }

        $product                = Product::find($id);
        $product->name          = $request->name;
        if($request->hasFile('image')){
            $product->image         = $fileProductimage;
        }
        $product->des           = $request->des;
        $product->sku           = $request->sku;
        $product->slug          = Str::slug($request->name);
        $product->amount        = $request->amount;
        $product->category_id   = $request->category_id;
        $product->brand_id      = $request->brand_id;
        $product->color_id      = $request->color_id;
        $product->size_id       = $request->size_id;
        $product->product_type       = $request->product_type;
        $product->save();

        return response()->json([
            'status'=>200,
            'message'=> 'Product Updated Successfully!',
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return response()->json([
                'status'=> 400,
                'errors'=> 'Unauthenticated user',
            ]);
        }

        $product = Product::find($id);
        if($product)
        {
            $product->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'product Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'product not found!',
            ]);
        }
    }
}
