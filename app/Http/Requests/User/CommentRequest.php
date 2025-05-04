<?php

namespace App\Http\Requests\User;

use App\Rules\MaxWordsRule;
use App\Rules\NoBannedWordsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check() || auth('admin')->check();
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->isMethod('put')) {
                return;
            }
            if ($this->filled('post_id') && $this->filled('parent_id')) {
                $validator->errors()->add('post_id', 'You cannot provide both post_id and parent_id at the same time.');
            }
        });
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'body' => ['required', 'min:5', new NoBannedWordsRule(['no', 'homely', 'bad']), new MaxWordsRule(50)],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ];
        if ($this->isMethod('post')) {
            $rules['post_id'] = ['required_without:parent_id', 'prohibited_if:parent_id,!null'];
        }
        if($this->isMethod('put')){
            $rules['parent_id'] = ['exists:comments,id'];
        }
        return $rules;
    }

    /**
     * Custom validation error messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'body.required' => 'The comment body is required.',
            'body.min' => 'The comment must be at least 5 characters.',
            'post_id.required_without' => 'Post ID is required unless this is a reply.',
            'post_id.exists' => 'The selected Post ID does not exist.',
            'parent_id.exists' => 'The selected Parent Comment does not exist.',
        ];
    }


    /**
     * Get the custom attributes for the defined validation rules.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'body' => 'Comment',
            'post_id' => 'Post id',
            'parent_id' => 'Parent id',
        ];
    }


    public function passedValidation()
    {
        return "Vlaidation passed";
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                "message" => "error Validation",
                "errors" => $validator->errors(),
            ], 422)
        );


    }
}
