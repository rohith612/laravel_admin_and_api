<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //

    public $offer_status = [
        '1' => 'inactive',
        '2' => 'active',
    ];

    public function offer_groups(){
        return $this->hasMany('App\OfferGroupMap', 'offer_id');
    }
}
