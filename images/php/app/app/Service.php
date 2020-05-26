<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

//    protected $table = 'products';

    protected $fillable = [
        'service_name', 'price', 'service_description', 'plan'
    ];

}