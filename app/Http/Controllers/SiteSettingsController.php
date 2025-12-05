<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteSettingsController extends Controller
{
    public static function header(){
        if(Auth::guard('admin')->user()->access->settings == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.sitesettings.headersettings',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first()
        ]);
    }
    public static function footer(){
        if(Auth::guard('admin')->user()->access->settings == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.sitesettings.footersettings',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first()
        ]);
    }
    public static function update(Request $request){
        if(Auth::guard('admin')->user()->access->settings != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $SiteSetting = SiteSetting::updateInfo($request);
        $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message =' Site Settings has been updated.';
                $notification->notification_for = 'Settings';
                $notification->item_id = $SiteSetting->id;
                $notification->save();
        return back();
    }
    public static function updateHeader(Request $request){
        if(Auth::guard('admin')->user()->access->settings != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $SiteSetting = SiteSetting::updateHeader($request);
        $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message =' Site Header Settings has been updated.';
                $notification->notification_for = 'Settings';
                $notification->item_id = $SiteSetting->id;
                $notification->save();
        return back();
    }
    public static function updateFooter(Request $request){
        if(Auth::guard('admin')->user()->access->settings != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $SiteSetting = SiteSetting::updateFooter($request);
        $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message =' Site Footer Settings has been updated.';
                $notification->notification_for = 'Settings';
                $notification->item_id = $SiteSetting->id;
                $notification->save();
        return back();
    }
}
