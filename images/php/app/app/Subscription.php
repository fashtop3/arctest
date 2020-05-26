<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference_id', 'user_id', 'service_id', 'auth_token', 'price'
    ];

    protected $hidden = [
        'auth_token'
    ];
}
