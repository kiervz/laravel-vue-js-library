<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() 
    {
        $books = Book::all();

        return response()->json([
            'books' => $books
        ]);
    }

    public function store(BookRequest $request) 
    {
        $request['avail_copies'] = $request->total_copies;
        Book::create($request->all());

        return response()->json([
            'message' => 'Book Successfully Added'
        ]);
    }
}
