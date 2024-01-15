<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Brand;

class BrandController extends Controller
{

    public function index()
    {
        $brands = Brand::all();
        return response()->json([
            'status'=> 200,
            'brand' => $brands,
        ]);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {

        $rules = [
            'name'  => 'required',
        ];
    
        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return response()->json([
                'status'=> 400,
                'errors'=> $validator->messages(),
            ]);
        }
        else
        {
            $brand          = new Brand();
            $brand->name   = $request->name;
            $brand->save();

            return response()->json([
                'status'=>200,
                'message'=> 'Brand Created Successfully!',
            ]);
        }
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $brand = Brand::find($id);
        if($brand)
        {
            return response()->json([
                'status'=>200,
                'brand'=>$brand,
            ]);
        }
        else
        {
            return response()->josn([
                'status'=>404,
                'message'=>'No brand found!',
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name'  => 'required',
        ];
    
        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else
        {

            $brand          = Brand::find($id);
            $brand->name   = $request->name;
            $brand->save();

            return response()->json([
                'status'=>200,
                'message'=> 'product Created Successfully!',
            ]);
        }
    }


    public function destroy($id)
    {
        $brand = brand::find($id);
        if($brand)
        {
            $brand->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'brand Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'brand not found!',
            ]);
    }

}

}
