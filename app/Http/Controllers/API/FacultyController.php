<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\FacultyRequest;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacultyController extends Controller
{
    public function index() 
    {
        $faculties = Faculty::paginate(10);

        return response()->json([
            'faculties' => $faculties
        ], Response::HTTP_OK);
    }

    public function store(FacultyRequest $request) 
    {
        Faculty::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Faculty Successfully Added'
        ], Response::HTTP_OK);
    }

    public function update(FacultyRequest $request, $id)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Faculty Successfully Updated'
        ], Response::HTTP_OK);
    }

    public function destroy($id) 
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Faculty Successfully Deleted'
        ], Response::HTTP_OK);
    }
}
