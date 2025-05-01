<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>> The array of validation rules for the email and password fields.
     */


    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:admins,email'],
            'password' => ['required', 'min:8', 'string'],
        ];
    }


    /**
     * Returns an array of error messages for the request.
     *
     * This method is called after validation has failed and
     * the error messages have been generated.
     *
     * @return array<string, string> The array of validation error messages.
     */

    public function messages()
    {
         return[
             'email.required' => 'The email field is required.',
             'email.email' => 'Please provide a valid email address.',
             'email.unique' => 'This email address is already registered.',

             'password.required' => 'The password field is required.',
             'password.min' => 'The password must be at least 8 characters long.',
             'password.string' => 'The password must be a valid string.',
         ];
    }
}
