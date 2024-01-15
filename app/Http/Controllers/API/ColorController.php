<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use Validator;

class ColorController extends Controller
{

    public function index()
    {
        $colors = color::all();
        return response()->json([
            'status'=> 200,
            'color' => $colors,
        ]); 
    }

    public function create()
    {
        
    }


    public function store(Request $request)
    {
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
            $color          = new Color();
            $color->name    = $request->input('name');
            $color->save();

            return response()->json([
                'status' => 200,
                'message'=> 'color Created Successfully!',
            ]);
        }
    }


    public function show($id)
    {
       
    }


    public function edit($id)
    {
        $color = Color::find($id);
        if($color)
        {
            return response()->json([
                'status'=> 200,
                'color' => $color,
            ]);
        }
        else
        {
            return response()->josn([
                'status'=> 404,
                'message'=> 'No color found!',
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = $request->validate([
        'name' => 'required',
        ]);
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else
        {
            
            $color         = Color::find($id);
            $color->name   = $request->input('name');
            $color->save();


            return response()->json([
                'status'=>200,
                'message'=> 'product Created Successfully!',
            ]);
        }
    }


    public function destroy($id)
    {
       $color = color::find($id);
        if($color)
        {
            $color->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'color Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'color not found!',
            ]);
    }
}
}
