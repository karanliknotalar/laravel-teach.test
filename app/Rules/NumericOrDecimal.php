<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NumericOrDecimal implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value) || !preg_match('/^\d*(\.\d{1,2})?$/', $value)) {
            $fail('The :attribute must be either numeric or decimal.');
        }
    }

}
