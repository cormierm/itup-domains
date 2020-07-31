<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hostname extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'ip',
        'token',
        'expires_at',
        'verified_at',
    ];

    public function fullName(): string
    {

        return sprintf('%s.%s', $this->name, config('itup.domain'));
    }

    public function isExpired(): bool
    {

        return $this->expires_at < Carbon::now();
    }
}
