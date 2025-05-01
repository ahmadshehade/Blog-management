<?php

namespace App\Http\Requests\Auth;

use App\Rules\UniqueEmailForRegistration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'name' => Str::title(trim($this->firstname . ' ' . $this->lastname)),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'max:100'],
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore('id'),
            ],

            'password' => ['required', 'min:8', 'confirmed'],

        ];
    }

    public function messages(): array
    {
        return [

            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email address is already in use.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',


        ];
    }

    public function attributes(): array
    {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',

        ];
    }
}
