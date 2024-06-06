<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class Referral extends Model
{
    public static function setCookie($partner_id){
        Cookie::queue(Cookie::make('partner_id', $partner_id, 10000000));
    }
    public static function getCookie(){
        $user = User::find(Cookie::get('partner_id'))->first();
        return $user ? Cookie::get('partner_id') : false;
    }
}
