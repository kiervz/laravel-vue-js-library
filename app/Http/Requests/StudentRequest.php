<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'student_id' => $isMethodPut ? 'required|string|max:20|unique:students,student_id,' .$this->id : 'required|string|max:20|unique:students',
            'name' => 'required|alpha_spaces|max:200',
            'gender' => 'required|string|max:10',
            'major' => 'required|string|max:20',
            'phone' => 'required|string|max:11',
        ];
    }
}
