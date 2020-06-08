<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        $data = User::all();

        if($data) {
            return response()->json([
                'data' => $data
            ]);
        }
        return response()->json([
            'message' => "Not found"
        ], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {
        try {
            $user = User::find($request->user);
            return response()->json([
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required|between:2,100',
            'email' => 'required|email|unique:users|max:50',
        ]);

        try {
            $user = User::find($request->user);
            $user->name = ($request->name) ? $request->name : $user->name;
            $user->email = ($request->email) ? $request->email : $user->email;
            $user->password = ($request->password) ? bcrypt($request->password) : $user->password;
            $user->save();
    
            return response()->json([
                'message' => "successfully updated",
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request) : JsonResponse
    {
        try {
            $user = User::find($request->user);
            $user->delete();
            return response()->json([
                'message' => "successfully updated",
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Not found",
            ], 404);
        }
    }
}
