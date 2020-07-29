<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class NotReservedIp implements Rule
{

    public function passes($attribute, $value)
    {
        foreach (config('ip.reserved') as $reversed) {
            if (Str::startsWith($value, $reversed)) {
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
    public function message()
    {
        return 'The ip address is reserved and cannot be used.';
    }
}
