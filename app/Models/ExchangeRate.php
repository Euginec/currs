<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'base_curr_name',
        'curr_name',
        'buy',
        'sale',
        'provider',
        'curr_date',
    ];

}
