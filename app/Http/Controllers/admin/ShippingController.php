<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\District;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public static function index(){

        return view('admin.shipping.shipping',[
            'admin' => Auth::guard('admin')->user(),
            'shippings' =>  Shipping::latest()->paginate(10),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'countries' => Country::where('status' ,1)->get(),
            'districts' => District::all(),
        ]);
    }

    public static function store(Request $request){

        $country = Country::where('code', $request->country_code)->first();

        $existingShipping = Shipping::where('country_id', $country->id)
            ->where('shipping_area', $request->input('shipping_area'))
            ->first();

        if ($existingShipping) {
            return redirect()->back()->with('error', 'A price already exists for the shipping area.');
        }else{
            $rules=[
                'country_code' => 'required',
                'shipping_area' => 'required',
                'price' => 'required',
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->passes()){
                Shipping::saveInfo($request);
                return redirect(route('shipping'));
            }else{
                return back()->withErrors($validator);
            }
        }

    }

    public static function delete($id){
        Shipping::find($id)->delete();
        return redirect(route('shipping'));
    }

    public static function update(Request $request,$id){
        $rules=[
            'country_code' => 'required',
            'shipping_area' => 'required',
            'price' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()){
            Shipping::saveInfo($request,$id);
            return redirect(route('shipping'));
        }else{
            return back()->withErrors($validator);
        }
    }

}
