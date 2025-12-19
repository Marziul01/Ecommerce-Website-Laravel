<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\Userinfo;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewUserNotification;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use function Symfony\Component\String\b;
use Illuminate\Support\Facades\Hash;


class UserAuthController extends Controller
{
    private static $auth;

    public function userAuth(){
        if (Auth::check()) {
            return redirect()
                ->route('user.profile')
                ->with('info', 'You are already logged in.');
        }

        return view('frontend.auth.auth', [
            'siteSettings' => SiteSetting::find(1),
            'categories'   => Category::where('status', 1)
                                    ->orderBy('name', 'ASC')
                                    ->with('sub_category')
                                    ->get(),
            'cartContent'  => Cart::content(),
        ]);
    }

    public static function userRegister(Request $request){

        $admin = User::where('role', 0)->first();

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required | min:8 | confirmed',
            'checkbox' => 'required',
        ]);

        if ($validator->passes()) {
            self::$auth = new User();
            self::$auth->name = $request->name;
            self::$auth->email = $request->email;
            self::$auth->password = bcrypt($request->password);
            self::$auth->role = 1;
            self::$auth->save();

            Auth::login(self::$auth);

            $user = Auth::user();

            Notification::send($admin, new NewUserNotification($user));

            // Flash a message to the session
            Session::flash('sweet-alert', 'Registration Successful! You have been registered and logged in.');

            return redirect()->route('user.profile');

        }else{
            return redirect()->route('userAuth')
                ->withErrors($validator);
        }

    }

    public static function logout(){
        Auth::logout();
        return redirect(route('home'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required | email ',
            'password' => 'required | min:8 ',
        ]);

        if($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->get('remember'))){

                // if (session()->has('url.intended')){
                //     return redirect(session()->get('url.intended'));
                // }

                return redirect()->route('user.profile');
            }else{
                return redirect(route('userAuth'))->with('error', 'Either Email/Password is incorrect!');
            }
        }else{
            return redirect()->route('userAuth')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public static function forgetPassword(){
        return view('frontend.auth.forgetPassword', [
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
            'cartContent' => Cart::content(),
        ]);
    }

    public static function forgetResetLink(Request $request){
       $validator =  Validator::make($request->all(),[
           'email' => 'required|email|exists:users,email',
        ]);

       if ($validator->passes()){
           $token =  Str::random(60);

           DB::table('password_reset_tokens')->where('email', $request->email)->delete();

           DB::table('password_reset_tokens')->insert([
              'email' => $request->email,
              'token' => $token,
              'created_at' => now(),
           ]);

           $user = User::where('email', $request->email)->first();

           $mailData = [
             'token' => $token,
             'user' => $user,
           ];

           Mail::to($request->email)->send(new ResetPasswordMail($mailData));

           $successMessage = "Password Reset link has been sent to you email ! ";
           $request->session()->flash('success', $successMessage);
           return redirect(route('forgetPassword'));

       }else{
           return back()->withInput()->withErrors($validator);
       }
    }

    public static function resetPassword($token){
        $user = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($user !== null){
            return view('frontend.auth.resetPassword', [
                'siteSettings' => SiteSetting::where('id', 1)->first(),
                'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
                'cartContent' => Cart::content(),
                'token' => $token,
            ]);
        }else{
            return redirect(route('forgetPassword'))->withErrors('Your password reset link is expired . Please try again !');
        }

    }

    public static function ResetPasswordForm(Request $request){
        $token = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        $email = $token->email;

        if ($token !== null){
            $rules = [
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ];

            // Validation for other fields
            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {
                // Update user information
                $user = User::where('email', $email)->first();
                $user->password = Hash::make($request->password);
                $user->save();

                DB::table('password_reset_tokens')->where('email', $email)->delete();

                $successMessage = "Your New Password has been updated successfully. Login and enjoy shopping !";
                $request->session()->flash('success', $successMessage);
                return redirect(route('userAuth'));
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return redirect(route('forgetPassword'))->withErrors('Your password reset link is expired . Please try again !');
        }

    }


}
