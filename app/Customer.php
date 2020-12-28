<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public function groups(){
        return $this->hasOne('App\CustomerGroup','id','group');
    }
}
