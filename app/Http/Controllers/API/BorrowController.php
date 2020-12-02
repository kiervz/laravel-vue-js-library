<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        $borrow = new Borrow();
        $borrow->borrower_id = $request->borrower_id;
        $borrow->isbn = $request->isbn;
        $borrow->user_id = Auth::id();
        $borrow->date_borrowed = Carbon::now();
        $borrow->due_date = Carbon::now();
        $borrow->penalty = 0;
        $borrow->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book Successfully Issued!'
        ], Response::HTTP_OK);
    }

    public function show($id) 
    {
        $data = DB::table('borrows')
            ->join('books', 'borrows.isbn', '=', 'books.isbn')
            ->join('users', 'borrows.user_id', '=', 'users.id')
            ->select('books.isbn', 'books.title', 'books.author', 'borrows.date_borrowed', 'borrows.due_date', 'borrows.penalty', 'users.id','users.name')
            ->where('borrows.borrower_id', $id)
            ->get();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

}
