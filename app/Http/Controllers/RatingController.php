<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\NewReviewNotfication;
use App\Notifications\NewUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public static function submitReview(Request $request){
        if(Auth::guard('admin')->user()->access->review_manage != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $validator = Validator::make($request->all(),[
            'product_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required',
            'rating' => 'required',
        ]);
        if ($validator->passes()){
            $admin = User::where('role', 0)->first();
            Rating::saveInfo($request);
            $product = Product::where('id', $request->product_id)->first();
            $name = $product->name;
            $data = [
              'product' =>  $name,
              'rating' =>  $request->rating,
            ];
            Notification::send($admin, new NewReviewNotfication($data));
            
            return back();
        }else{
            return back()->withErrors($validator);
        }
    }

    public static function reviews(){
        if(Auth::guard('admin')->user()->access->review_manage == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.reviews.reviews',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'reviews' => Rating::latest()->paginate(10),
        ]);
    }

    public static function reviewDestroy(Request $request, $id){
        if(Auth::guard('admin')->user()->access->review_manage != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $rating = Rating::find($id);
        if (isset($rating)){
            $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = $rating->product->name .' Review has been deleted.';
                $notification->notification_for = 'Review';
                $notification->item_id = $rating->id;
                $notification->save();

            $rating->delete();
            $successMessage = "Your Review has been deleted";
            $request->session()->flash('success', $successMessage);

            

            return back();
        }
    }

    public static function reviewShow($id){
        $rating = Rating::statusCheck($id);
        $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = $rating->product->name .' Review status has been updated.';
                $notification->notification_for = 'Review';
                $notification->item_id = $rating->id;
                $notification->save();
        return back();
    }
}
