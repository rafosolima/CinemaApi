<?php

namespace App\Http\Controllers;

use App\Director;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DirectorController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        $data = Director::all();

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required|unique:directors,name',
        ]);

        $director = Director::create($request->all());

        return response()->json([
            'data' => $director
        ]);
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
            $director = Director::find($request->director);
            return response()->json([
                'data' => $director
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Not found"
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
            'name' => 'unique:directors,name',
        ]);

        try {
            //code...
            $director = Director::find($request->director);
            $director->name = ($request->name) ? $request->name : $director->name;
            $director->save();
    
            return response()->json([
                'message' => "successfully updated",
                'data' => $director
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
            $director = Director::find($request->director);
            $director->delete();
            return response()->json([
                'message' => "successfully updated",
                'data' => $director
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Not found"
            ], 404);
        }
    }
}
