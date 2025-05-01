<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
class MaxWordsRule implements Rule
{
    protected $maxWords;

    public function __construct(int $maxWords){
        $this->maxWords = $maxWords;
    }


    /**
     * Summary of passes
     * @param mixed $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute,$value){

        $wordCount = str_word_count(strip_tags($value));
        if($wordCount>$this->maxWords){
            return false;
        }
        return true;
    }

    public function message()
    {
        return "The :attribute must not contain more than {$this->maxWords} words.";
    }

}
