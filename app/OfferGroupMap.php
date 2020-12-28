<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferGroupMap extends Model
{
    protected $table = 'offer_group_map';

    public function map_groups(){
        return $this->hasOne('App\CustomerGroup', 'id', 'group_id');
    }

    public function offer(){
        return $this->hasOne('App\Offer', 'id', 'offer_id');
    }

    public function customer(){
        return $this->hasMany('App\Customer', 'group', 'group_id');
    }

    // public function available_offer() {
    //     return $this->offer()->where('validity','=', 2);
    // }

}
