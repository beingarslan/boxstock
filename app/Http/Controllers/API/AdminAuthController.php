<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Validation\ValidationException;
use Auth;

class AdminAuthController extends Controller
{


    public function login(Request $request) 
    {
 
        $validator = $request->validate([
            'email'         =>  'required|email|max:80',
            'password'      =>  'required|min:8',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $admin = Admin::where('email', $request->email)->first();
            if (!$admin->is_admin || ! Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid Credentials',
                ]);
            } else {

                $token  =   $admin->createToken($admin->email.'_Token')->plainTextToken;
                return response()->json([
                        'status'=>200,
                        'username'=>$admin->name,
                        'token' => $token,
                        'message'=>'Login Successfull',
                ]);
            }
        }
    }



    public function chekingAuthenticated()
    {
        return response()->json(['message'=>'You are in', 'status'=>200], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Logout Success',
        ]);
    }

}
