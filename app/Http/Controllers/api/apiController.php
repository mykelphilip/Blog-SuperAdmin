<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
// use App\Models\blog;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Http\JsonResponse;

class apiController extends Controller
{
//SUPERADMIN INTERFACE

public function index(){
    return User::all();
}
//REGISTRATION API
    public function register(Request $request){
try{
        
    $users = $request->validate([
        'name'=> 'required',
        'email'=> 'required|email|unique:users',
        'password'=> 'required|confirmed|min:6',
    ]);

        if(!$users){
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',]
                );
        }else{   
        
    $users = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

        }

   $token = $users->createToken($request->name);

    return response()->json([
        'status' => true,
        'message' => 'User Created Successfully!',
        'token' => $token->plainTextToken], 200);


    }catch(\Throwable $th){
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ],500);
    }
  }



  //LOGIN API
  public function login(Request $request){
    try{
       $requests = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
       ]);

       if(!$requests){
        return response()->json([
            'status' => false,
            'message' => 'Login Validation Error, Check Information Entered'], 401);
       }

    //    if(!Auth::attempt($request->only(['email', 'password']))){
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'Email and Password Entered, does not match our records'
    //         ], 401);
    //    }

       $user =  User::where('email', $request->email)->first();
       if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'status'=>false,
                    'message' => 'Username and password entered is not correct, Try again!'
                ]);
       }

       $token = $user->createToken($user->name);

       return response()->json([
        'status' => true,
        'message' => 'User Successfully Logged In',
        'token' => $token->plainTextToken,
        ], 200);


   }catch(\Throwable $th){
    return response()->json([ 
        'status'=>false,
        'message'=> $th->getMessage(),
      ], 500);
  }
}


//User Data

public function userdata(Request $request){
    try{
        $users = $request->get("token");
      

        if(!$users){
            return response()->json([
                'status' => false,
                'message' => 'User Not Authorized'
            ], 401);
        }
        return response()->json([
            'status' => true,
            'message' => "Users Dashboard"
        ], 200);
       
    
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Profile Information',
    //         'data' => [
    //             'id' => $user->id,
    //             'email' => $user->email,
    //             'name' => $user->name,
    //         ],
    //     ], 200);
    
    }catch(\Throwable $th){
        return response()->json([ 
            'status'=>false,
            'message'=> $th->getMessage(),
          ], 500);
      }


//PROFILE API
// public function profile(){
    
//     $userData = Auth::user();

//     // if(!$userData){
//     //     return response()->json([
//     //         'status' => false,
//     //         'message' => 'user not authenticated',
//     //     ], 401);
//     // }

//     return response()->json([
//         'status' => true,
//         'message' => 'Profile Information',
//         'data' => $userData,
//     ], 200);

// }

}
public function logout(Request $request){

    $request->user()->tokens()->delete();

    return  response()->json([
        'status' => true,
        'message'=>'You are logged out!',
    ]);
}


}