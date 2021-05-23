<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        $authors = Author::all();
        return view('pages.book.index', compact('books', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();
        return view('pages.book.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_name' => 'required|max:255',
            'image' => 'nullable|file|mimes:jpeg,png',
            'audio' => 'nullable|file|max:200000|mimes:audio/mpeg,mpga,mp3,wav,aac',

        ]);


        $book = new Book();

        $book->name = $request->book_name;



        if ($request->file('image')) {
            $file = $request->file('image');
            $uniqueid = uniqid();
            $original_name = $file->getClientOriginalName();
            $size = $file->getSize();
            $extension = $file->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $path = $file->storeAs('/upload/files/image', $filename);
            $path_url = '/files/image/' . $filename;

            $book->image = $path_url;
        }

        if ($request->file('audio')) {
            $file = $request->file('audio');
            $uniqueid = uniqid();
            $original_name = $file->getClientOriginalName();
            $size = $file->getSize();
            $extension = $file->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $path = $file->storeAs('/upload/files/audio', $filename);
            $path_url = '/files/audio/' . $filename;

            $book->audio = $path_url;
        }

        $book->save();

        $book->authors()->attach($request->author_id, ['book_id' => $book->id]);


        return redirect(route('page.books'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::where('id', $id)->first();
        $authors = Author::all();
        $authorIds = $book->authors()->pluck('author_id');

        return view('pages.book.edit', compact('book', 'authors', 'authorIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'book_name' => 'required|max:255',
            'image' => 'nullable|file|mimes:jpeg,png',
            'audio' => 'nullable|file|max:200000|mimes:audio/mpeg,mpga,mp3,wav,aac',

        ]);

        $book = Book::find($id);

        $book->name = $request->book_name;


        if ($request->file('image')) {
            $file = $request->file('image');
            $uniqueid = uniqid();
            $original_name = $file->getClientOriginalName();
            $size = $file->getSize();
            $extension = $file->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $path = $file->storeAs('/upload/files/image', $filename);
            $path_url = '/files/image/' . $filename;

            $book->image = $path_url;
        }

        if ($request->file('audio')) {
            $file = $request->file('audio');
            $uniqueid = uniqid();
            $original_name = $file->getClientOriginalName();
            $size = $file->getSize();
            $extension = $file->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $path = $file->storeAs('/upload/files/audio', $filename);
            $path_url = '/files/audio/' . $filename;

            $book->audio = $path_url;
        }

        $book->authors()->sync($request->author_id, ['book_id' => $id]);


        $book->save();



        return redirect(route('page.books'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if ($book) {
            $book->delete();
        }

        return redirect(route('page.books'));
    }

    public function searchBookByAuthors(Request $request)
    {

        $authorIds = $request->author_id;
        
        $query = Book::query();
        $authors = Author::all();

        

        // $books = Book::whereHas('authors', function ($query) use ($authorIds) {
        //     $query->where('authors.id', '=', $authorIds);
        // })->get();

        foreach ($authorIds as $author_id) {
            $query = $query->whereHas('authors', function ($query) use ($author_id) {
                $query->where('authors.id', '=', $author_id);
            });
        }

        $books = $query->get();

        


        return view('pages.book.search-result', compact('books', 'authors'));
    }
}
