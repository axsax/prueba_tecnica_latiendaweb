<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Models\Movie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends ApiController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movie = Movie::all();
        if (count($movie)==0) {
            return $this->errorResponse('Without movies',404);
        }
        return $this->showAll($movie);
    }
    public function getCompleteMovies()
    {
        $movie = Movie::select('movies.name as movie_name','categories.name as category_name','authors.name as author_name','release_date','producer')->leftJoin('categories', 'categories.id', '=', 'movies.category_id')->leftJoin('authors', 'authors.id', '=', 'movies.author_id')->get();
        //$movie = Movie::select('name', 'produce', 'release_date')->lef;
        if (count($movie)==0) {
            return $this->errorResponse('Without movies',404);
        }
        return $this->showAll($movie);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return $this->showOne($movie);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(MovieUpdateRequest $request,Movie $movie)
    {

        if ($request->has('name')) {
            $movie->name = $request->name;
        }
        if ($request->has('producer')) {
            $movie->status = $request->producer;
        }
        if ($request->has('category_id')) {
            $movie->category_id = $request->category_id;
        }
        if ($request->has('author_id')) {
            $movie->author_id = $request->author_id;
        }

        if (!$movie->isDirty()) {
            return $this->errorResponse('At least one different value must be specified to update', 400);
        }
        try {
            $movie->save();
            return $this->perfectResponse('Movie edited correctly',201);
        } catch (\Throwable $th) {
            return $this->errorResponse('Error editing the data', 400);
        }
    }
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request)
    {
        $movie = new Movie([
            'name' => $request->name,
            'producer' => $request->producer,
            'release_date' => $request->release_date,
            'category_id' => $request->category_id,
            'author_id' => $request->author_id,
        ]);
        try {
            $movie->save();
            return $this->perfectResponse('Movie created correctly',201);
        } catch (Exception $th) {
            return $this->errorResponse($th,400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        try {
            $movie->delete();
            return $this->perfectResponse('movie deleted',200);
        } catch (Exception $th) {
            return $this->errorResponse($th,500);
        }
    }
}
