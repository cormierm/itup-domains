<?php

namespace App\Rules;

use App\Hostname;
use Illuminate\Contracts\Validation\Rule;

class AvailableHostname implements Rule
{
    public function passes($attribute, $value): bool
    {

        return !Hostname::query()
            ->where('name', $value)
            ->exists();
    }

    public function message(): string
    {

        return 'The hostname has already been taken.';
    }
}
