<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('authors',AuthorsController::class);
Route::apiResource('categories',CategoryController::class);
Route::apiResource('movies',MovieController::class);
Route::apiResource('movies',MovieController::class);
Route::get('getCompleteMovies', [MovieController::class, 'getCompleteMovies']);
