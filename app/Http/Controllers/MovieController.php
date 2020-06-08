<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        $data = Movie::all();

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
            'maturity_rating_id' => 'required|exists:maturity_ratings,id',
            'directors' => 'required|Array|min:1',
            'directors.*' => 'required|numeric|exists:directors,id',
            'actors' => 'required|Array|min:1',
            'actors.*' => 'required|numeric|exists:actors,id',
            'name' => 'required|unique:movies,name',
            'sinopse' => 'required',
            'duration' => 'required|integer',
            'imdb' => 'required|numeric|between:0,10'
        ]);

        $data = $request->all();

        $movie = Movie::create($data);

        $movie->directors()->attach($data['directors']);
        $movie->actors()->attach($data['actors']);

        return response()->json([
            'data' => array_merge($movie->getAttributes(), [
                'directors' => $movie->directors()->get(),
                'actors' => $movie->actors()->get()
            ])
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
            $movie = Movie::find($request->movie);
            return response()->json([
                'data' => $movie
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
            'maturity_rating_id' => 'exists:maturity_ratings,id',
            'name' => 'unique:movies,name',
        ]);

        try {
            $movie = Movie::find($request->movie);
            $movie->maturity_rating_id = ($request->maturity_rating_id) ? $request->maturity_rating_id : $movie->maturity_rating_id;
            $movie->name = ($request->name) ? $request->name : $movie->name;
            $movie->sinopse = ($request->sinopse) ? $request->sinopse : $movie->sinopse;
            $movie->duration = ($request->duration) ? $request->duration : $movie->duration;
            $movie->imdb = ($request->imdb) ? $request->imdb : $movie->imdb;
            $movie->save();
    
            return response()->json([
                'message' => "successfully updated",
                'data' => $movie
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
            $movie = Movie::find($request->movie);
            $movie->delete();
            return response()->json([
                'message' => "successfully updated",
                'data' => $movie
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Not found"
            ], 404);
        }
    }
}
