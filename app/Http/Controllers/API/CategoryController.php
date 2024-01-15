<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'status'=> 200,
            'category' => $categories,
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
            $category          = new Category();
            $category->name   = $request->name;
            $category->save();

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

        $category = Category::find($id);
        if($category)
        {
            return response()->json([
                'status'=>200,
                'category'=>$category,
            ]);
        }
        else
        {
            return response()->josn([
                'status'=>404,
                'message'=>'No category found!',
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

            $category         = Category::find($id);
            $category->name   = $request->name;
            $category->save();


            return response()->json([
                'status'=>200,
                'message'=> 'product Created Successfully!',
            ]);
        }
    }


    public function destroy($id)
    {
        $category = Category::find($id);
        if($category)
        {
            $category->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Category Deleted Successfully!',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=> 'category not found!',
            ]);
        }
    }
}
