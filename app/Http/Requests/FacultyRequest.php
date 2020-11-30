<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isMethodPut = $this->method() == 'PUT';
        return [
            'faculty_id' => $isMethodPut ? 'required|string|max:20|unique:faculties,faculty_id,' .$this->id : 'required|string|max:20|unique:faculties',
            'name' => 'required|alpha_spaces|max:200',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|max:11',
        ];
    }
}
