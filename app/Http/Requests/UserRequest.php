<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $isMethod = $this->method() == 'PUT';
        return [
            'name' => 'required|alpha_spaces|max:200',
            'email' => 'required|email',
            'user_type' => 'required',
            'password' => !$isMethod ? 'required_with:confirm_password|string|same:confirm_password|min:8|max:25' : '',
            'confirm_password' => !$isMethod ? 'string|min:8|max:25' : '',
        ];
    }
}
