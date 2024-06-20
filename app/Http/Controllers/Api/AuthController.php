<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\SignupRequest;

class AuthController extends Controller
{
    public function users(){
        $users = User::all();
        
        // return response()->json($users, 200);
        return response(compact('users'));
    }

    public function delete($id){

        $user = User::find($id)->first();

        $user->delete();
        
        $users = User::all();
        
        // return response()->json($users, 200);
        return response(compact('users'));
    }

    public function signup(SignupRequest $request){
            $data = $request->validated();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $token = $user->createToken('main')->plainTextToken;
            // \Log::info('User created: ' . $user->id);

            return response(compact('user','token'), 201);
            // return response()->json(compact('user','token'), 201);
        }

    // public function login(LoginRequest $request){
    //         $credentials = $request->validated();
    //         if(!Auth::attempt($credentials)){
    //                 return response([
    //                     'message' => 'Provided email address or password is incorrect'
    //                 ], 422);
    //         }

    //         $user = Auth::user();

    //         $token = $user->createToken('main')->plainTextToken;
            
    //         return response(compact('user', 'token'), 200);
    //     }

    public function logout(Request $request){
            $user = $request->user();
            $user->currentAccessToken()->delete();

            return response('',204);
        }
}
