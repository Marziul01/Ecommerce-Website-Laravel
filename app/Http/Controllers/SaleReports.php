<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleReports extends Controller
{
    public static function salesReport(Request $request)
{
    if(Auth::guard('admin')->user()->access->sales_report == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
    $query = Order::query();

    // Apply date filter if dates are provided
    if ($request->has('from_date') && $request->has('to_date')) {
        $query->whereBetween('created_at', [
            $request->input('from_date') . ' 00:00:00',
            $request->input('to_date') . ' 23:59:59'
        ]);
    }

    $orderdetails = $query->get();

    $totalPurchaseCost = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->whereIn('orders.status', [5, 8]) // Include only orders with status 5 or 8
        ->select(DB::raw('SUM(COALESCE(products.purchase_price, 0) * order_items.qty) as total_purchase_cost'))
        ->whereBetween('orders.created_at', [
            $request->input('from_date') . ' 00:00:00',
            $request->input('to_date') . ' 23:59:59'
        ])
        ->first();

    return view('admin.report.report', [
        'admin' => Auth::guard('admin')->user(),
        'siteSettings' => SiteSetting::where('id', 1)->first(),
        'orderdetails' => $orderdetails,
        'totalPurchaseCost' => $totalPurchaseCost,
    ]);
}

}
