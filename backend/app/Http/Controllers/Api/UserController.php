<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Just for test purpose 
    public function index(){
        $users = 0;
        if($users > 0){
            return response()->json([
                'success' => true,
                'users' => $users
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'users' => 'No users were found'
            ], 404);
        }
    }

    // Register New User
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|min:6',
            'phone' => 'required|digits|min:11|max:15',
        ]);
        if($validator->fails()){
            return response()->json([
              'success' => false,
              'message' => $validator->messages()
            ], 400);
        }
        else{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone
            ]);
            if($user){
                return response()->json([
                 'success' => true,
                  'message' => 'User created successfully'
                ], 201);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong'
                ], 400);
            }
        }
    }
}
