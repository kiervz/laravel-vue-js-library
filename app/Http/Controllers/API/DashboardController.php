<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function booksCount() 
    {
        $books = DB::table('books')->sum('total_copies');
        return response()->json(['books' => $books]);
    }

    public function booksLost() 
    {
        $books_lost = DB::table('borrows')->where('status', '2')->count();
        return response()->json(['books_lost' => $books_lost]);
    }

    public function totalStudents()
    {
        $students = DB::table('students')->count();
        return response()->json(['students' => $students]);
    }

    public function totalFaculties()
    {
        $faculties = DB::table('faculties')->count();
        return response()->json(['faculties' => $faculties]);
    }

    public function booksBorrowed() 
    {
        $books_borrowed = DB::table('borrows')->where('status', '1')->count();
        return response()->json(['books_borrowed' => $books_borrowed]);
    }
    
    public function booksOverdue() 
    {
        $books_overdue = DB::table('borrows')
                            ->where('status', 1)
                            ->where('penalty', '>', 0)
                            ->count();
        return response()->json(['books_overdue' => $books_overdue]);
    }
}
