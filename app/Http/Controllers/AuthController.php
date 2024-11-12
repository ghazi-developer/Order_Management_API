<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
      // Register Method
      public function register(Request $request)
      {
          // Validate the incoming data
          $validator = Validator::make($request->all(), [
              'name' => 'required|string|max:255',
              'email' => 'required|email|unique:users,email',
              'password' => 'required',
              'role' => 'required|in:seller,admin,client', // Ensure valid role is provided
          ]);
  
          if ($validator->fails()) {
              return response()->json(['errors' => $validator->errors()], 422);
          }
  
          // Create a new user
          $user = User::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => Hash::make($request->password),
            
                
          ]);
        $roles = ['seller', 'admin', 'client'];
        foreach ($roles as $role) {
        if (!Role::where('name', $role)->exists()) {
            Role::create(['name' => $role]); 
        }
    }
          // Assign role automatically
          $user->assignRole($request->role);  // Assuming you are using Spatie/Permission package for roles
            $this->saveUserToFile($user);
          return response()->json([
              'message' => 'User registered successfully',
              'user' => $user,
          ], 201);
      }
      
      protected function saveUserToFile($user)
      {
            $fileName='user_records.txt';
            $userData="Email: {$user->email} Name:{$user->name}";
            Storage::append($fileName,$userData);
      }
      // Login Method
      public function login(Request $request)
      {
          
          $validate = Validator::make(
              $request->all(),
              [
                  'email' => 'required|email',  
                  'password' => 'required'
              ]
          );
      
         
          if ($validate->fails()) {
              return response()->json([
                  'status' => false,
                  'message' => 'Authentication Failed',
                  'errors' => $validate->errors()->all()
              ], 401);
          }
      
          
          if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
              // dd($request);
              $auth = Auth::user();  
              $user = User::where('email',$request->email)->first();   
              $user->remember_token=$auth->createToken("API TOKEN")->plainTextToken;
              $user->save();
              return response()->json([
                  'status' => true,
                  'message' => 'Authenticated',
                  'token' => $auth->createToken("API TOKEN")->plainTextToken,  
                  'token_type' => 'bearer'
              ], 200);
          } else {
             
              return response()->json([
                  'status' => false,
                  'message' => 'Email and Password do not match',
              ], 401);
          }
        }      
}
