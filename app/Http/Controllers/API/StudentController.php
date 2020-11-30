<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() 
    {
        $students = Student::paginate(10);

        return response()->json([
            'students' => $students
        ]);
    }
}
