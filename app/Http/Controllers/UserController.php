<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\Userinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->access->user_manage == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.users.manage',[
            'admin' => Auth::guard('admin')->user(),
            'users' =>  User::where('role', 1)->latest()->paginate(10),
            'siteSettings' => SiteSetting::where('id', 1)->first()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::guard('admin')->user()->access->user_manage != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users ',
        ];

        // Validation for other fields
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            // Update user information
            $user = new User();
            $user->role = 1;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            $successMessage = "User has been created successfully";
            $request->session()->flash('success', $successMessage);

            $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = $user->name .' A New User has been created.';
                $notification->notification_for = 'User';
                $notification->item_id = $user->id;
                $notification->save();

            return redirect(route('users.index'));
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::guard('admin')->user()->access->user_manage != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $user = User::find($id);

        // Separate validation for email
        $emailValidator = Validator::make($request->only('email'), [
            'email' => 'required|unique:users,email,' . $user->id . ',id',
        ]);

        if ($emailValidator->fails()) {
            return back()->withErrors($emailValidator);
        }

        $rules = [
            'name' => 'required',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6';
            $rules['confirm_password'] = 'required|same:password';
        }

        // Validation for other fields
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            $successMessage = "User has been updated successfully";
            $request->session()->flash('success', $successMessage);

            $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = $user->name .' User has been updated.';
                $notification->notification_for = 'User';
                $notification->item_id = $user->id;
                $notification->save();

            return redirect(route('users.index'));
        } else {
            return back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::guard('admin')->user()->access->user_manage != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $user = User::find($id);
        $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = $user->name .' User has been deleted.';
                $notification->notification_for = 'User';
                $notification->item_id = $user->id;
                $notification->save();
        $user->delete();

        return redirect(route('users.index'));
    }
}
