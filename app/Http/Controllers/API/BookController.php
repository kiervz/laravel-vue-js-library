<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    /**
     * Create a new BookController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() 
    {
        $books = BookResource::collection(Book::all());

        return response()->json([
            'books' => $books
        ], Response::HTTP_OK);
    }

    public function store(BookRequest $request) 
    {
        $request['avail_copies'] = $request->total_copies;
        Book::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Book Successfully Added'
        ], Response::HTTP_CREATED);
    }

    public function update(BookRequest $request, $id) 
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Book Successfully Updated'
        ], Response::HTTP_OK);
    }

    public function destroy($id) 
    {
        $book = Book::find($id);
        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Book Successfully Deleted'
        ], Response::HTTP_OK);
    }
}
