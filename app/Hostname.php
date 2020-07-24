<?php

namespace App;

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
        'verified_at'
    ];

    public function fullName(): string
    {

        return sprintf('%s.%s', $this->name, config('itup.domain'));
    }
}
