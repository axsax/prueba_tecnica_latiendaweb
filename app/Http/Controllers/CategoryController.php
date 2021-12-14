<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorsRequest;
use App\Http\Requests\NamesRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        if (count($category)==0) {
            return $this->errorResponse('Without Categories',404);
        }
        return $this->showAll($category);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(NamesRequest $request,Category $category)
    {
        if ($request->has('name')) {
            $category->name = $request->name;
            $category->save();
            return $this->perfectResponse('category edited correctly',200);
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
        $category = new Category([
            'name' => $request->name,
        ]);
        try {
            $category->save();
            return $this->perfectResponse('Category created correctly',201);
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
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->perfectResponse('category deleted',200);
        } catch (Exception $th) {
            return $this->errorResponse($th,500);
        }
    }
}
