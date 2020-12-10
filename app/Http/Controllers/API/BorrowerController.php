<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    public function show($id)
    {
        $borrower = Student::where('student_id', $id)->get();
        
        if ($borrower->count() == 0) {
            $borrower = Faculty::where('faculty_id', $id)->get();
        }

        $penalty = Borrow::where('borrower_id', $id)
                        ->where('status', 1)
                        ->sum('penalty');
        
        return response()->json([
            'borrower' => $borrower,
            'penalty' => $penalty
        ]);
    }

}
