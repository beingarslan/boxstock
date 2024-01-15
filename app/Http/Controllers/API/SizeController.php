<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Size;

class SizeController extends Controller
{

    public function index()
    {
        $sizes = Size::all();
        return response()->json([
            'status'=> 200,
            'size' => $sizes,
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
            $size         = new Size();
            $size->name   = $request->name;
            $size->save();

            return response()->json([
                'status'=>200,
                'message'=> 'category Created Successfully!',
            ]);
        }
    }


    public function show($id)
    {

    }

    public function edit($id)
    {

//        dd($id);
        $size = Size::find($id);

        if($size)
        {
            return response()->json([
                'status'=> 200,
                'size' => $size,
            ]);
        }

        return response()->josn([
            'status'=> 404,
            'message'=> 'No size found!',
        ]);
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

            $size         = Size::find($id);
            $size->name   = $request->name;
            $size->save();

            return response()->json([
                'status'=>200,
                'message'=> 'product Created Successfully!',
            ]);
        }
    }


    public function destroy($id)
    {
      $size = Size::find($id);
        if($size)
        {
            $size->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'size Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'size not found!',
            ]);
    }
}
}
