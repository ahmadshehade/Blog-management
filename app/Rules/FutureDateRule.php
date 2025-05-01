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
     * Summary of passes
     * @param mixed $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute,$value){
        if ($value && Carbon::parse($value)->isFuture()){
                return Carbon::parse($value)->isFuture();
            }
        }
    public function message(){
      return "The publish date must be in the future.";
    }


}
