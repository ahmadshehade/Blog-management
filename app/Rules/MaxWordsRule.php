<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxWordsRule implements ValidationRule
{
    protected $maxWords;

    public function __construct( $maxWords )
    {
        $this->maxWords = $maxWords;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $wordCount = str_word_count(strip_tags($value));
        if($wordCount>$this->maxWords){
            $fail("The {$attribute} must not contain more than {$this->maxWords} words. Current count: {$wordCount}.");
        }
    }
}
