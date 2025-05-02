<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class CanonicalUrlRule implements Rule
{

/**
 * Validates that the given value is a valid HTTPS URL with no path, query, or fragment.
 *
 * @param string $attribute The name of the attribute being validated.
 * @param string $value The value of the attribute to validate.
 * @return bool True if the value is a valid HTTPS URL without path, query, or fragment; false otherwise.
 */


    public function passes($attribute,$value){
       
        if (!filter_var($value, FILTER_VALIDATE_URL) || !str_starts_with($value, 'https://')) {
            return false;
        }

        $parsed = parse_url($value);
        return empty($parsed['path']) && empty($parsed['query']) && empty($parsed['fragment']);
    }
    


    public function message(): string
    {
        return 'The :attribute must be a valid HTTPS URL without any path, query, or fragment (e.g., https://example.com).';
    }

}