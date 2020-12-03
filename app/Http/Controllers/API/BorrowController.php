<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BorrowController extends Controller
{
    public function store(Request $request)
    {
        $book_isbn = '';
        $status = "success";
        $message = "Book Successfully Issued!";
        
        if (!empty(Borrow::where('isbn', $request->isbn)->where('borrower_id', $request->borrower_id)->first())) 
        {
            $status = "error";
            $message = "The book is already borrowed by the borrower.";
        } else {
            $borrow = new Borrow();
            $borrow->borrower_id = $request->borrower_id;
            $borrow->isbn = $request->isbn;
            $book_isbn = $borrow->isbn;
            $borrow->user_id = Auth::id();
            $borrow->date_borrowed = Carbon::now();
            $borrow->due_date = Carbon::now();
            $borrow->penalty = 0;
            $borrow->save();
    
            $book = Book::where('isbn', $book_isbn)->first();
            $book->avail_copies = $book->avail_copies - 1;
            $book->update();
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ], Response::HTTP_OK);
    }

    public function show($id) 
    {
        $data = DB::table('borrows')
            ->join('books', 'borrows.isbn', '=', 'books.isbn')
            ->join('users', 'borrows.user_id', '=', 'users.id')
            ->select('borrows.id','books.isbn', 'borrows.status', 'books.title', 'books.author', 'borrows.date_borrowed', 'borrows.due_date', 'borrows.penalty', 'users.name')
            ->where('borrows.borrower_id', $id)
            ->where('borrows.status', 1)
            ->get();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function update($id)
    {   
        $book_isbn = '';
        $borrow = Borrow::findOrFail($id);
        $borrow->status = 0;
        $book_isbn = $borrow->isbn;
        $borrow->update();

        $book = Book::where('isbn', $book_isbn)->first();
        $book->avail_copies += 1;
        $book->update();

        return response()->json([
            'status' => 'success',
            'message' => "Book Successfully Returned!"
        ], Response::HTTP_OK);
    }

}
