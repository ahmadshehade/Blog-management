<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class NoBannedWordsRule implements Rule
{


    protected array $bannedWords;

    public function __construct(array $bannedWords)
    {
        $this->bannedWords = $bannedWords;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value){
        foreach ($this->bannedWords as $word) {
            if (stripos($value, $word) !== false) {
                return false;
            }
        }
        return true;
    }



    /**
     * Get the validation error message.
     *
     * @return string
     */


    public function message(){
        return 'The :attribute contains prohibited language.';
    }
}