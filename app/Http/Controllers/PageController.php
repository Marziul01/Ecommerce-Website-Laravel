<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Mail\OrderAdminEmail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\NewContactNotification;
use App\Notifications\NewOrderNotification;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public static function about(){
        return view('frontend.pages.about',[
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
            'brands' => Brand::orderBy('name', 'ASC')->where('status', '1')->get(),
            'cartContent' => Cart::content(),
            'about' => Page::find(1),
        ]);
    }

    public static function contact(){
        return view('frontend.pages.contact',[
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
            'brands' => Brand::orderBy('name', 'ASC')->where('status', '1')->get(),
            'cartContent' => Cart::content(),
            'contact' => Page::find(2),
        ]);
    }

    public static function privacy(){
        return view('frontend.pages.privacy_policy',[
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
            'brands' => Brand::orderBy('name', 'ASC')->where('status', '1')->get(),
            'cartContent' => Cart::content(),
            'privacy' => Page::find(3),
        ]);
    }

    public static function terms_condition(){
        return view('frontend.pages.terms',[
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
            'brands' => Brand::orderBy('name', 'ASC')->where('status', '1')->get(),
            'cartContent' => Cart::content(),
            'terms' => Page::find(4),
        ]);
    }

    public static function contactForm(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ];

        // Validation for other fields
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $admin = User::where('role', 0)->first();
            $siteemail = SiteSetting::first();
            $name = $request->name;

            Mail::to($siteemail->email)->send(new Contact($request));

            Notification::send($admin, new NewContactNotification($name));

            $successMessage = "Your message has been sent successfully. We will get back to you shortly ! ";
            $request->session()->flash('success', $successMessage);
            return redirect(route('contact'));
        } else {
            return redirect(route('contact'))->withErrors($validator);
        }
    }

}
