<?php

use App\Http\Resources\AuthorDetailedResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/books', function () {
    return BookResource::collection(Book::with('authors')->get());
});

Route::get('/authors', function () {
    return AuthorDetailedResource::collection(Author::all());
});
