<?php

namespace App\Http\Requests\User;

use App\Rules\FutureDateRule;
use App\Rules\MaxWordsRule;
use App\Rules\SlugFormatRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check() || auth('admin')->check();
    }

    public function prepareForValidation()
    {

        if ($this->is_published) {
            $keywords = Str::words(strip_tags($this->meta_description), 15, '') . ' ' . $this->tags;
            $this->merge([
                "title"=>Str::title(trim($this->title)),
                "slug" => Str::slug($this->title),
                "keywords" => $keywords,
            ]);
        } else {
            $this->merge([
                "title"=>Str::title(trim($this->title)),
                "slug" => Str::slug($this->title),
                "keywords" => str::words(strip_tags($this->title), 7, ''),
            ]);
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId = $this->route('id');
        return [
            'title' => [
                'required',
                'string',
                'max:50',
                Rule::unique('posts', 'title')->ignore($postId),
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                new SlugFormatRule(),
                Rule::unique('posts', 'slug')->ignore($postId),
            ],
            'body' => ['required', 'string', 'min:16'],
            'is_published' => ['boolean', 'in:0,1'],
            'publish_date' => ['required_if:is_published,1', 'date', new FutureDateRule()],
            'meta_description' => ['required_if:is_published,1', 'string', 'max:150'],
            'keywords' => ['required', 'string', new MaxWordsRule(20)],
            'tags' => ['required_if:is_published,1', 'string', 'max:50'],

        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not exceed 50 characters.',
            'title.unique' => 'The title has already been taken.',

            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug must not exceed 255 characters.',
            'slug.unique' => 'The slug has already been taken.',

            'body.required' => 'The body field is required.',
            'body.string' => 'The body must be a string.',
            'body.min' => 'The body must be at least 16 characters.',

            'is_published.in' => 'The publish status must be either 0 or 1.',
            'is_published.boolean' => 'The publish status must be boolean.',

            'publish_date.date' => 'Publish date must be a valid date.',
            'publish_date.required_if' => 'Publish date is required when the post is published.',

            'meta_description.string' => 'The meta description must be a string.',
            'meta_description.max' => 'The meta description must not exceed 150 characters.',
            'meta_description.required_if' => 'Meta description is required when the post is published.',

            'tags.string' => 'The tags must be a string.',
            'tags.max' => 'The tags must not exceed 50 characters.',
            'tags.required_if' => 'Tags are required when the post is published.',

            'keywords.required' => 'The keywords field is required when the post is published.',
            'keywords.string' => 'The keywords must be a string.',
            'keywords.max_words' => 'The keywords must not exceed 10 words.',


        ];
    }


    public function passedValidation()
    {

        return "Validation Passed";
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }


    public function attributes()
    {
        return [
            'title' => 'Title',
            'slug' => 'Slug',
            'body' => 'Body',
            'is_published' => 'Publish Status',
            'publish_date' => 'Publish Date',
            'meta_description' => 'Meta Description',
            'tags' => 'Tags',
            'keywords' => 'Keywords',
        ];
    }

}
