<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class FutureDateRule implements Rule
{


    /*************************************************************************************/


    /**
     * Check if the given value is in the future.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */

    public function passes($attribute, $value)
    {
        if ($value && Carbon::parse($value)->isFuture()) {
            return Carbon::parse($value)->isFuture();
        }
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */

    public function message()
    {
        return "The publish date must be in the future.";
    }


}
