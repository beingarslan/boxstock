<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Variant;

class VariantController extends Controller
{

    public function index()
    {
        $variants = Variant::all();
        return response()->json([
            'status'=> 200,
            'variant' => $variants,
        ]);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
//        dd($request);
        
        $validator = $request->validate([
            'name' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=> 400,
                'errors'=> $validator->messages(),
            ]);
        }
        else
        {
            $variant             = new Variant();
            $variant->status     = $request->status;
            if($request->hasFile('image')){
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
            $variant->stock     = $request->stock;
            $variant->amount     = $request->amount;
            $variant->product_id = $request->product_id;
            $variant->size_id = $request->size_id;
            $variant->save();

            return response()->json([
                'status'=>200,
                'message'=> 'Variant Created Successfully!',
            ]);
        }
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $variant = Variant::find($id);

        if($variant)
        {
            return response()->json([
                'status'=> 200,
                'variant' => $variant,
            ]);
        }
        else
        {
            return response()->josn([
                'status'=> 404,
                'message'=> 'No variant found!',
            ]);
        }
    }


    public function update(Request $request, $id)
    {

        $variant             = Variant::find($id);
        if($request->hasFile('image')){
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
        $variant->status     = $request->status;
        $variant->stock     = $request->stock;
        $variant->amount     = $request->amount;
        $variant->product_id = $request->product_id;
        $variant->size_id = $request->size_id;

        $variant->save();

        return response()->json([
            'status'=>200,
            'message'=> 'Variant Updated Successfully!',
        ]);
    }


    public function destroy($id)
    {
        $variant = Variant::find($id);
        if($variant)
        {
            $variant->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Variant Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'variant not found!',
            ]);
    }
    }
}
