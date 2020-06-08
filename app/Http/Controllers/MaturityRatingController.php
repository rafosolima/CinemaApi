<?php

namespace App\Http\Controllers;

use App\MaturityRating;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MaturityRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        $data = MaturityRating::all();

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
            'name' => 'required|unique:maturity_ratings,name',
            'description' => 'required',
        ]);

        $maturityRating = MaturityRating::create($request->all());

        return response()->json([
            'data' => $maturityRating
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
            $maturityRating = MaturityRating::find($request->maturityRating);
            return response()->json([
                'data' => $maturityRating
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
            'name' => 'unique:maturity_ratings,name',
        ]);

        try {
            $maturityRating = MaturityRating::find($request->maturityRating);
            $maturityRating->name = ($request->name) ? $request->name : $maturityRating->name;
            $maturityRating->description = ($request->description) ? $request->description : $maturityRating->description;
            $maturityRating->save();
    
            return response()->json([
                'message' => "successfully updated",
                'data' => $maturityRating
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
            $maturityRating = MaturityRating::find($request->maturityRating);
            $maturityRating->delete();
            return response()->json([
                'message' => "successfully updated",
                'data' => $maturityRating
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Not found"
            ], 404);
        }
    }
}
