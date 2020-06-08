<?php

namespace App\Http\Controllers;

use App\Actor;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        $data = Actor::all();

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
            'name' => 'required|unique:actors,name',
        ]);

        $actor = Actor::create($request->all());

        return response()->json([
            'data' => $actor
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
            $actor = Actor::find($request->actor);
            return response()->json([
                'data' => $actor
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
            'name' => 'unique:actors,name',
        ]);

        try {
            $actor = Actor::find($request->actor);
            $actor->name = ($request->name) ? $request->name : $actor->name;
            $actor->save();
    
            return response()->json([
                'message' => "successfully updated",
                'data' => $actor
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
            $actor = Actor::find($request->actor);
            $actor->delete();
            return response()->json([
                'message' => "successfully deleted",
                'data' => $actor
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Not found"
            ], 404);
        }
    }
}
