<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    protected $fillable = [
        'name',
        'english_name',
        'alphabetic_code',
        'digit_code',
        'rate',
    ];

}
