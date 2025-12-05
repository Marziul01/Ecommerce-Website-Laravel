<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    public static function saveInfo($request,$id=null){
        $price = 0;
        $country = Country::where('code', $request->country_code)->first();
        if ($request->shipping_area == 'Inside Dhaka'){
            $dhaka = 'Dhaka';
        }


        if (!$id == null){
            $shipping = Shipping::find($id);
            $message = 'updated';
        }else{
            $shipping = new Shipping();
            $message = 'added';
        }

        $shipping->country_id = $country->id;

        if ($request->shipping_area == 'Inside Dhaka'){
            $shipping->region = $dhaka;
        }else{
            $shipping->region = $request->region;
        }

        $shipping->shipping_area = $request->shipping_area;
        $shipping->shipping_type = $request->shipping_type;

        if ($request->shipping_type == 'Free Shipping'){
            $shipping->price = $price;
        }else{
            $shipping->price = $request->price;
        }

        $shipping->save();

        $request->session()->flash('success', 'Shipping method ' . $message. ' successfully');

        return $shipping;
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
