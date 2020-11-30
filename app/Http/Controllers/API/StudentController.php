<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public function index() 
    {
        $students = Student::paginate(10);

        return response()->json([
            'students' => $students
        ], Response::HTTP_OK);
    }

    public function store(StudentRequest $request) 
    {
        Student::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Student Successfully Added'
        ], Response::HTTP_OK);
    }

    public function update(StudentRequest $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Student Successfully Updated'
        ], Response::HTTP_OK);
    }

    public function destroy($id) 
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Student Successfully Deleted'
        ], Response::HTTP_OK);
    }

}
