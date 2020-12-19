<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //
    public $table = 'test1';


    protected $fillable = [
'username','password'
    ];

    protected $timestamp = false;
}
