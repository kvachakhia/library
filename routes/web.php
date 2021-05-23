<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes([
    'register' => true, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);



Route::middleware(['auth'])->name('page.')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/books', [App\Http\Controllers\BookController::class, 'index'])->name('books');
    Route::get('/search/books', [App\Http\Controllers\BookController::class, 'searchBookByAuthors'])->name('search_books');
    Route::get('/authors', [App\Http\Controllers\AuthorController::class, 'index'])->name('authors');
});



Route::middleware(['admin'])->name('admin.')->group(function () {

    Route::name('book.')->group(function () {
        Route::get('/add/new/book', [App\Http\Controllers\BookController::class, 'create'])->name('create');
        Route::post('/add/new/book', [App\Http\Controllers\BookController::class, 'store'])->name('store');
        Route::post('/remove/book/{id}', [App\Http\Controllers\BookController::class, 'destroy'])->name('destroy');
        Route::get('/book/edit/{id}', [App\Http\Controllers\BookController::class, 'edit'])->name('edit');
        Route::post('/update/book/{id}', [App\Http\Controllers\BookController::class, 'update'])->name('update');
    });

    Route::name('author.')->group(function () {
        Route::get('/add/new/author', [App\Http\Controllers\AuthorController::class, 'create'])->name('create');
        Route::post('/add/new/author', [App\Http\Controllers\AuthorController::class, 'store'])->name('store');
        Route::post('/remove/author/{id}', [App\Http\Controllers\AuthorController::class, 'destroy'])->name('destroy');
        Route::get('/author/edit/{id}', [App\Http\Controllers\AuthorController::class, 'edit'])->name('edit');
        Route::post('/update/author/{id}', [App\Http\Controllers\AuthorController::class, 'update'])->name('update');
    });
});
