<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    //

    public function customer(){
        return $this->hasMany('App\Customer','group','id');
    }

    public function map_offer(){
        return $this->hasMany('App\OfferGroupMap','group_id','id');
    }
}
