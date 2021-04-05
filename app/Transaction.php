<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'action',
        'details',
        'hostname_id',
        'token',
    ];

    const ACTION_RENEW = 'renew';

    public function hostname() : BelongsTo
    {

        return $this->belongsTo(Hostname::class);
    }
}
