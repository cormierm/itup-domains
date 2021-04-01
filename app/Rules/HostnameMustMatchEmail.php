<?php

namespace App\Rules;

use App\Hostname;
use Illuminate\Contracts\Validation\Rule;

class HostnameMustMatchEmail implements Rule
{

    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function passes($attribute, $value): bool
    {

        return Hostname::query()
            ->where('name', $value)
            ->where('email', $this->email)
            ->exists();
    }

    public function message(): string
    {

        return 'Hostname and email do not match our records.';
    }
}
