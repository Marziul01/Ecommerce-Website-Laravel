<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    private static $coupon,$action;

    public static function saveInfo($request, $id=null){
        if ($id != null){
            self::$coupon = PaymentMethod::find($id);
            self::$action = 'updated';
        }else{
            self::$coupon = new PaymentMethod();
            self::$action = 'added';
        }

        self::$coupon->type = $request->type;
        self::$coupon->name = $request->name;
        self::$coupon->number = $request->number;
        self::$coupon->note = $request->note;
        self::$coupon->account_name = $request->account_name;
        self::$coupon->bank_name = $request->bank_name;
        self::$coupon->branch_name = $request->branch_name;

        self::$coupon->save();

        $successMessage = "Payment Method has been " . self::$action . " successfully";
        $request->session()->flash('success', $successMessage);
    }


    public static function statusCheck($id){
        self::$coupon = PaymentMethod::find($id);
        if (self::$coupon->status == 1){
            self::$coupon->status = 0;
        }else{
            self::$coupon->status = 1;
        }

        self::$coupon->save();
    }
}
