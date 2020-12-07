<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $this->middleware('jwt.auth');
    }

    public function index() 
    {
        $books = Book::paginate(10);

        return response()->json([
            'books' => BookResource::collection($books)->response()->getData(true)
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

    public function update_copies(Request $request, $id)
    {
        $number_copies = $request->input('number_copies');
        $book = Book::findOrFail($id);

        $request->validate([
            'number_copies' => 'numeric|required',
        ]);

        $book->total_copies += $number_copies;
        $book->avail_copies += $number_copies;
        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book copies successfully updated!'
        ], Response::HTTP_OK);
    }

    public function show($id) 
    {
        $book = Book::where('isbn', $id)->get();

        return response()->json([
            'book' => $book,
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

    public function inventory()
    {
        $data = DB::table('books')
            ->join('book_categories', 'books.category_id', '=', 'book_categories.id')
            ->select('books.id','book_categories.name as category', 'books.call_number', 'books.isbn', 
                    'books.title', 'books.author', 'books.publisher', 'books.total_copies', 'books.avail_copies', 
                DB::raw("(SELECT COUNT(id) as count FROM borrows WHERE (books.isbn = borrows.isbn) AND (status = 1)) AS total_borrowers"),
                DB::raw("(SELECT COUNT(id) as count FROM borrows WHERE (books.isbn = borrows.isbn) AND (status = 3)) AS total_lost")    
            )
            ->get();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function borrowed()
    {
        $data = DB::table('borrows')
            ->join('books', 'borrows.isbn', '=', 'books.isbn')
            ->join('users', 'borrows.user_id', '=', 'users.id')
            ->select('borrows.id', 'books.call_number', 'books.title', 'books.author', 'borrows.date_borrowed', 'borrows.due_date', 'borrows.penalty', 'users.name',
                DB::raw("(SELECT name FROM students WHERE (students.student_id = borrows.borrower_id)) AS student_name"),
                DB::raw("(SELECT name FROM faculties WHERE (faculties.faculty_id = borrows.borrower_id)) AS faculty_name"),
            )
            ->where('borrows.status', 1)
            ->get();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function returned()
    {
        $data = DB::table('borrows')
            ->join('books', 'borrows.isbn', '=', 'books.isbn')
            ->join('users', 'borrows.user_id', '=', 'users.id')
            ->select('books.call_number', 'books.isbn', 'books.title', 'books.author', 'borrows.date_borrowed', 'borrows.due_date', 'users.name',
                DB::raw("(SELECT name FROM students WHERE (students.student_id = borrows.borrower_id)) AS student_name"),
                DB::raw("(SELECT name FROM faculties WHERE (faculties.faculty_id = borrows.borrower_id)) AS faculty_name"),
            )
            ->where('borrows.status', 0)
            ->get();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function lost()
    {
        $data = DB::table('borrows')
            ->join('books', 'borrows.isbn', '=', 'books.isbn')
            ->join('users', 'borrows.user_id', '=', 'users.id')
            ->select('books.call_number', 'books.isbn', 'books.title', 'books.author', 'borrows.date_borrowed', 'borrows.due_date', 'users.name',
                DB::raw("(SELECT name FROM students WHERE (students.student_id = borrows.borrower_id)) AS student_name"),
                DB::raw("(SELECT name FROM faculties WHERE (faculties.faculty_id = borrows.borrower_id)) AS faculty_name"),
            )
            ->where('borrows.status', 3)
            ->get();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function overdue()
    {
        $this->borrowOverdue();

        $data = DB::table('borrows')
            ->join('books', 'borrows.isbn', '=', 'books.isbn')
            ->join('users', 'borrows.user_id', '=', 'users.id')
            ->select('books.call_number', 'books.title', 'books.author', 'borrows.date_borrowed', 'borrows.due_date', 'users.name',
                DB::raw("(SELECT name FROM students WHERE (students.student_id = borrows.borrower_id)) AS student_name"),
                DB::raw("(SELECT name FROM faculties WHERE (faculties.faculty_id = borrows.borrower_id)) AS faculty_name"),
            )
            ->where('borrows.status', 1)
            ->where('borrows.penalty', '>', 0)
            ->get();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    private function borrowOverdue() 
    {
        $borrows = Borrow::where('status', 1);
        foreach ($borrows as $borrows) {
            $diff_day = now()->diff($borrows->due_date)->d;
            $diff_hour = now()->diff($borrows->due_date)->h;

            if ($diff_hour > 0) {
                $diff_day += 1;
            }

            $borrows->penalty = $diff_day;
            $borrows->update();
        }
    }
}
