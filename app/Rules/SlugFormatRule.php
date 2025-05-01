<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class SlugFormatRule implements Rule
{
           //###########################if use ValidationRule############################


        //    public function validate(string $attribute, mixed $value, Closure $fail): void
        //    {
        //        if (!preg_match('/^[a-z0-9-]+$/', $value)) {
        //            $fail('The slug may only contain lowercase letters, numbers, and hyphens (-).');

        //        }
        //    }
        #################################################################################





    /**
     * Determine if the given attribute value is a valid slug.
     *
     * @param string $attribute The name of the attribute being validated.
     * @param mixed $value The value of the attribute to validate.
     * @return bool True if the value is a valid slug, false otherwise.
     */


    public function passes($attribute, $value)  {
        return preg_match("/^[a-z0-9-]+$/", $value);
    }


    /**
     * Get the validation error message for an invalid slug.
     *
     * @return string The error message indicating the slug format requirements.
     */


    public function message(){
        return "The slug may only contain lowercase letters, numbers, and hyphens (-).";
    }


}
