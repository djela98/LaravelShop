<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['errors' => $validator->errors()]
            );
        } else {
            $user = User::create([
                'name' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email . '+' . $user->name . 'REGTOKEN')->plainTextToken;

            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Registered!',
                    'user' => $user->name,
                    'token' => $token
                ]
            );
        }
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(
                ['errors' => $validator->errors()]
            );
        } else {
            $user = User::where('name', $request->username)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Pogrešan username ili password'
                ]);
            } else {
                $token = $user->createToken($user->email . '+' . $user->name . 'REGTOKEN')->plainTextToken;

                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Logged in!',
                        'user' => $user->name,
                        'token' => $token,
                        'role' => $user->role
                    ]
                );
            }
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logout uspešan'
        ]);
    }
}
