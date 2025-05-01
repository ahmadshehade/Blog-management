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
     * Summary of validate
     * @param string $attribute
     * @param mixed $value
     * @param \Closure $fail
     * @return bool
     */



    public function passes($attribute, $value)  {
        return preg_match("/^[a-z0-9-]+$/", $value);
    }

    public function message(){
        return "The slug may only contain lowercase letters, numbers, and hyphens (-).";
    }


}
