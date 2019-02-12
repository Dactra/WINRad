<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radwin extends Model
{
    protected $fillable = ['username', 'password', 'radwinserial', 'radwinservicecategory', 'radwinname', 'radwinlocation', 'radwinvlan', 'radwinregisteravailability'];
}
