<?php

namespace App\Http\Requests\User;

use App\Rules\MaxWordsRule;
use App\Rules\NoBannedWordsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentRequest extends FormRequest
{

    /**
     * Summary of authorize :wiche user can access this request
     * @return bool
     */
    public function authorize(): bool
    {
        return auth('api')->check() || auth('admin')->check();
    }


    /**
     * Summary of rules
     * @return array{body: array<MaxWordsRule|NoBannedWordsRule|string>, parent_id: string[], post_id: string[]}
     */
    public function rules(): array
    {
        return [
            'body' => [
                'required',
                'min:5',
                new NoBannedWordsRule(['no', 'homely', 'bad']),
                new MaxWordsRule(50)
            ],
            'post_id' => ['required', 'exists:posts,id'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ];
    }


    /**
     * Summary of withValidator
     * @param mixed $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->isMethod('put')) return;

            // تأكد أن post_id موجود دائمًا
            if (! $this->filled('post_id')) {
                $validator->errors()->add('post_id', 'Post ID is required for both comments and replies.');
            }
        });
    }

    /**
     * Summary of messages
     * @return array{body.min: string, body.required: string, parent_id.exists: string, post_id.exists: string, post_id.required: string}
     */
    public function messages(): array
    {
        return [
            'body.required' => 'The comment body is required.',
            'body.min' => 'The comment must be at least 5 characters.',
            'post_id.required' => 'The post ID is required.',
            'post_id.exists' => 'The selected post does not exist.',
            'parent_id.exists' => 'The selected parent comment does not exist.',
        ];
    }

    /**
     * Summary of attributes
     * @return array{body: string, parent_id: string, post_id: string}
     */
    public function attributes(): array
    {
        return [
            'body' => 'Comment',
            'post_id' => 'Post ID',
            'parent_id' => 'Parent Comment ID',
        ];
    }

    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
