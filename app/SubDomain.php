<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubDomain extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'ip',
    ];
}
