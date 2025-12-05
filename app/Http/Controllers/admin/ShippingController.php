<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
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
        if(Auth::guard('admin')->user()->access->shipping == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.shipping.shipping',[
            'admin' => Auth::guard('admin')->user(),
            'shippings' =>  Shipping::latest()->paginate(10),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'countries' => Country::where('status' ,1)->get(),
            'districts' => District::all(),
        ]);
    }

    public static function store(Request $request){
        if(Auth::guard('admin')->user()->access->shipping != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
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
                $shipping = Shipping::saveInfo($request);
                $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = 'A new shipping method has been created .';
                $notification->notification_for = 'Shipping';
                $notification->item_id = $shipping->id;
                $notification->save();
                return redirect(route('shipping'));
            }else{
                return back()->withErrors($validator);
            }
        }

    }

    public static function delete($id){
        if(Auth::guard('admin')->user()->access->shipping != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        Shipping::find($id)->delete();
        $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A shipping method has been deleted .';
            $notification->notification_for = 'Shipping';
            $notification->item_id = $id;
            $notification->save();
        return redirect(route('shipping'));
    }

    public static function update(Request $request,$id){
        if(Auth::guard('admin')->user()->access->shipping != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $rules=[
            'country_code' => 'required',
            'shipping_area' => 'required',
            'price' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()){
            Shipping::saveInfo($request,$id);
            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A shipping method has been updated .';
            $notification->notification_for = 'Shipping';
            $notification->item_id = $id;
            $notification->save();
            return redirect(route('shipping'));
        }else{
            return back()->withErrors($validator);
        }
    }

}
