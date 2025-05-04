<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class MaxWordsRule implements Rule
{
    protected $maxWords;

    public function __construct(int $maxWords)
    {
        $this->maxWords = $maxWords;
    }


    /**
     * Check if the given attribute contains more than $this->maxWords words.
     *
     * @param string $attribute
     * @param string $value
     * @return bool
     */

    public function passes($attribute, $value)
    {

        $wordCount = str_word_count(strip_tags($value));
        if ($wordCount > $this->maxWords) {
            return false;
        }
        return true;
    }


    /**
     * Get the validation error message.
     *
     * @return string The error message indicating the attribute exceeds the maximum word limit.
     */


    public function message()
    {
        return "The :attribute must not contain more than {$this->maxWords} words.";
    }

}
