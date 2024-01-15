<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ImageUpdateController extends Controller
{

    public function update_image(Request $request) {
//        dd($request);
        if($request->type === 'product') {
            if($request->hasFile('image')){
                $product                = Product::find($request->id);
                if($product->image) {
                    unlink(public_path($product->image));
                }
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $user_iamge = $filename.'_'.time().'.'.$extension;
                $request->file('image')->move(public_path('/product'),$user_iamge);
                $fileProductimage = "/product/" . $user_iamge;
            } else {
                $fileProductimage = 'no.png';
            }

            if($request->hasFile('image')){
                $product->image         = $fileProductimage;
            }
            $product->save();
        }

        if($request->type === 'variant') {
            $variant = Variant::find($request->id);
            if($request->hasFile('image')){
                if($variant->image) {
                    unlink(public_path($variant->image));
                }

                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $user_iamge = $filename.'_'.time().'.'.$extension;
                $request->file('image')->move(public_path('/variant'),$user_iamge);
                $fileVariant = "/variant/" . $user_iamge;
            } else {
                $fileVariant = 'no.png';
            }
            if($request->hasFile('image')){
                $variant->image         = $fileVariant;
            }

            $variant->save();
        }
    }
}
