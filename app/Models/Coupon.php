<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    private static $coupon,$action;

    public static function saveInfo($request, $id=null){
        if ($id != null){
            self::$coupon = Coupon::find($id);
            self::$action = 'updated';
        }else{
            self::$coupon = new Coupon();
            self::$action = 'added';
        }

        self::$coupon->name = $request->name;
        self::$coupon->code = $request->code;
        self::$coupon->description = $request->description;
        self::$coupon->max_uses = $request->max_uses;
        self::$coupon->max_uses_user = $request->max_uses_user;
        self::$coupon->type = $request->type;
        self::$coupon->discount_amount = $request->discount_amount;
        self::$coupon->min_amount = $request->min_amount;
        self::$coupon->starts_at = $request->starts_at;
        self::$coupon->expires_at = $request->expires_at;

        self::$coupon->save();

        $successMessage = "Coupon has been " . self::$action . " successfully";
        $request->session()->flash('success', $successMessage);

        return self::$coupon;
    }


    public static function statusCheck($id){
        self::$coupon = Coupon::find($id);
        if (self::$coupon->status == 1){
            self::$coupon->status = 0;
        }else{
            self::$coupon->status = 1;
        }

        self::$coupon->save();
    }

}
