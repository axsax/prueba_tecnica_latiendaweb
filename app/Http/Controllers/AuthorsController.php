<?php

namespace App\Http\Controllers;

use App\Http\Requests\NamesRequest;
use App\Models\Author;
use Exception;
use Illuminate\Http\Request;

class AuthorsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();
        if (count($authors)==0) {
            return $this->errorResponse('Without authors',404);
        }
        return $this->showAll($authors);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return $this->showOne($author);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(NamesRequest $request,Author $author)
    {
        if ($request->has('name')) {
            $author->name = $request->name;
            $author->save();
            return $this->perfectResponse('author edited correctly',200);
        }else{
            return $this->errorResponse('Name not given',304);
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $author = new Author([
            'name' => $request->name,
        ]);
        try {
            $author->save();
            return $this->perfectResponse('author created correctly',201);
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
    public function destroy(Author $author)
    {
        try {
            $author->delete();
            return $this->perfectResponse('Author deleted',200);
        } catch (Exception $th) {
            return $this->errorResponse($th,500);
        }
    }
}
