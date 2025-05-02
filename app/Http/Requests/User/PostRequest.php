<?php

namespace App\Http\Requests\User;

use App\Rules\CanonicalUrlRule;
use App\Rules\FutureDateRule;
use App\Rules\MaxWordsRule;
use App\Rules\NoBannedWordsRule;
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
     *
     * @return bool
     */

    public function authorize(): bool
    {
        return auth('api')->check() || auth('admin')->check();
    }



 




    /**
     * Prepare the data for validation.
     *
     * If the post is published, it generates keywords from the meta description and tags,
     * sets the title in title case, creates a slug from the title, and sets the status.
     * If the post is not published, it generates keywords from the title,
     * sets the title in title case, creates a slug from the title, and sets the status.
     */



    public function prepareForValidation()
    {

        if ($this->is_published) {
            $keywords = Str::words(strip_tags($this->meta_description), 15, '') . ' ' . $this->tags;
            $this->merge([
                "title"=>Str::title(trim($this->title)),
                "slug" => Str::slug($this->title),
                "keywords" => $keywords,
                "status"=>$this->status??'draft',
            ]);
        } else {
            $this->merge([
                "title"=>Str::title(trim($this->title)),
                "slug" => Str::slug($this->title),
                "keywords" => str::words(strip_tags($this->title), 7, ''),
                "status"=>$this->status??'draft',
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
                'max:255',
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
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_published' => ['required', 'boolean', 'in:0,1'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_scheduled' => ['sometimes', 'boolean'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived', 'pending_review'])],
            'publish_date' => ['required_if:is_published,1', 'date', new FutureDateRule()],
            'meta_description' => ['required_if:is_published,1', 'string', 'max:255', new MaxWordsRule(10)],
            'keywords' => ['required', 'string', new MaxWordsRule(20)],
            'tags' => ['required_if:is_published,1', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'url',new CanonicalUrlRule()],
            'editor_notes' => [
                  $this->route('id') ? 'required' : 'nullable',
                 'string',
                  new MaxWordsRule(30),
                   new NoBannedWordsRule(['idiot', 'nonsense', 'invalid']),
                      ],

        ];
    }




    /**
     * Custom validation error messages.
     *
     * @return array<string, string>
     */

     public function messages(): array
     {
         return [
             'title.required' => 'The post title is required.',
             'title.string' => 'The post title must be a string.',
             'title.max' => 'The post title may not be greater than 255 characters.',
             'title.unique' => 'This post title has already been taken.',
     
             'slug.required' => 'The slug is required.',
             'slug.string' => 'The slug must be a string.',
             'slug.max' => 'The slug may not be greater than 255 characters.',
             'slug.unique' => 'This slug has already been taken.',
     
             'body.required' => 'The post body is required.',
             'body.string' => 'The post body must be a string.',
             'body.min' => 'The post body must be at least 16 characters.',
     
             'category_id.exists' => 'The selected category does not exist.',
     
             'is_published.required' => 'The publish status is required.',
             'is_published.boolean' => 'The publish status must be true or false (0 or 1).',
             'is_published.in' => 'The selected publish status is invalid.',
     
             'is_featured.boolean' => 'The featured status must be true or false (0 or 1).',
             'is_scheduled.boolean' => 'The scheduled status must be true or false (0 or 1).',
     
             'status.required' => 'The post status is required.',
             'status.in' => 'The selected post status is invalid.',
     
             'publish_date.required_if' => 'The publish date is required when the post is marked as published.',
             'publish_date.date' => 'The publish date must be a valid date.',
     
             'meta_description.required_if' => 'The meta description is required when the post is published.',
             'meta_description.string' => 'The meta description must be a string.',
             'meta_description.max' => 'The meta description may not be greater than 255 characters.',
     
             'keywords.required' => 'The keywords field is required.',
             'keywords.string' => 'The keywords must be a string.',
     
             'tags.required_if' => 'The tags field is required when the post is published.',
             'tags.string' => 'The tags must be a string.',
             'tags.max' => 'The tags may not be greater than 255 characters.',
     
             'canonical_url.url' => 'The canonical URL must be a valid URL.',
     
             'editor_notes.string' => 'The editor notes must be a string.',
         ];
     }
     




    /**
     * Actions to perform after validation passes.
     *
     * @return string A message indicating successful validation.
     */


    public function passedValidation()
    {

        return "Validation Passed";
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }



    /**
     * Get custom attributes for validator errors.
     *
     * This method is necessary when using the message helper with __().
     *
     * @return array<string, string> The array of custom attributes.
     */

     public function attributes()
     {
         return [
             'title' => 'Title',
             'slug' => 'Slug',
             'body' => 'Body',
             'category_id' => 'Category',
             'is_published' => 'Publish Status',
             'is_featured' => 'Featured Status',
             'is_scheduled' => 'Scheduled Status',
             'status' => 'Status',
             'publish_date' => 'Publish Date',
             'meta_description' => 'Meta Description',
             'tags' => 'Tags',
             'keywords' => 'Keywords',
             'canonical_url' => 'Canonical URL',
             'editor_notes' => 'Editor Notes',
         ];
     }


}