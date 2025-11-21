<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public static function index(){
        return view('admin.order.pending',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'orders' => Order::where('status', 1)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public static function ordersProcessing(){
        return view('admin.order.processing',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'orders' => Order::where('status', 3)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public static function ordersshiped(){
        return view('admin.order.shipped',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'orders' => Order::where('status',4)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public static function ordersComplete(){
        return view('admin.order.completed',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'orders' => Order::whereIn('status', [ 5,8 ])->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public static function ordersCancel(){
        return view('admin.order.cancelled',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'orders' => Order::where('status', 2)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public static function ordersreturnrequesst(){
        return view('admin.order.returnRequest',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'orders' => Order::where('status', 6)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public static function ordersreturenen(){
        return view('admin.order.returned_refunded',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'orders' => Order::where('status', 7)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public static function viewOrders($id){
        return view('admin.order.orderDetail',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'order' => Order::find($id),
        ]);
    }

    public static function orderStatusUpdate(Request $request, $id){
        $order = Order::find($id);
        $order->status = $request->status;
        if ($request->status == 2){
            $order->reason = $request->reason;
        }
        $order->save();
        return back()->with(session()->flash('success', 'Order Status Updated'));
    }

    public static function orderPaymentStatusUpdate(Request $request, $id){
        $order = Order::find($id);
        $order->payment_status = $request->payment_status;
        $order->save();
        return back()->with(session()->flash('success', 'Order Payment Status Updated'));
    }
}
