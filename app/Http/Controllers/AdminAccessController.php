<?php

namespace App\Http\Controllers;

use App\Models\AdminAccess;
use App\Models\AdminNotification;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AdminAccessController extends Controller
{
    public function admins(){
        if(Auth::guard('admin')->user()->access->control_panel == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        $notifications = DB::table('notifications')->where('read_at', NULL)->get();
        $totalNotification = $notifications->count();
        return view('admin.admin.admins',[
            'admins' => User::where('role', 0)->where('role_type' , '!=' , 'Super Admin' )->get(),
            'adminAccess' => AdminAccess::all(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'notifications' => $notifications,
            'totalNotification' => $totalNotification,
            'admin' => Auth::guard('admin')->user(),
            
        ]);
    }

    public function store(Request $request)
    {

        if(Auth::guard('admin')->user()->access->control_panel != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        // ================= VALIDATION =================
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'phone'     => 'required|string|max:20|unique:users,phone',
            'role_type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {

            // =================== GENERATE PASSWORD ===================
            $plainPassword = Str::random(10);    // random password (e.g. Abc123Xyz9)
            $hashedPassword = Hash::make($plainPassword);

            // =================== CREATE USER ===================
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'role_type' => $request->role_type,
                'role'      => 0, // <---- admin role
                'password'  => $hashedPassword,
            ]);

            // =================== SAVE ADMIN ACCESS ===================
            $access = new AdminAccess();
            $access->admin_id = $user->id;

            foreach ($access->getFillable() as $column) {
                if ($column != 'admin_id' && $column != 'created_at' && $column != 'updated_at' && $column != 'reports' && $column != 'control_panel') {
                    $access->{$column} = $request->{$column};
                }
            }

            $access->save();

            // =================== SEND EMAIL TO ADMIN ===================
            $loginUrl = route('admin.login');

            $emailData = [
                'name'     => $user->name,
                'email'    => $user->email,
                'password' => $plainPassword,
                'loginUrl' => $loginUrl,
            ];

            Mail::send('email.new-admin', $emailData, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Your Admin Panel Login Details');
            });

            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'New Admin User created .';
            $notification->notification_for = 'Admin';
            $notification->item_id = $user->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'New Admin User added successfully!',
                'data'    => $user
            ]);

        }
        catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while saving service!',
                    'error'   => $e->getMessage()
                ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        if(Auth::guard('admin')->user()->access->control_panel != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }

        $admin = User::findOrFail($id);

        // ===== VALIDATION =====
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . $admin->id,
            'phone'     => 'nullable|string|max:20|unique:users,phone,' . $admin->id,
            'role_type' => 'required|string|max:255',
            'password'  => 'nullable|min:8',
            'confirm_password' => 'nullable|required_with:password'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        if ($request->password) {

                // ===== CHECK LOGGED-IN USER PASSWORD =====
                if (!Hash::check($request->confirm_password, auth()->user()->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your password is incorrect. Password change denied.'
                    ], 403);
                }
        }

        try {

            // ========= UPDATE USER BASIC INFO =========
            $admin->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'role_type' => $request->role_type,
            ]);

            // ========= UPDATE ACCESS TABLE =========
            $access = AdminAccess::where('admin_id', $admin->id)->first();

            foreach ($access->getFillable() as $col) {
                if (!in_array($col, ['admin_id', 'created_at', 'updated_at', 'reports' , 'control_panel'])) {
                    $access->{$col} = $request->{$col};
                }
            }

            $access->save();

            // ========= IF PASSWORD CHANGE REQUESTED =========
            if ($request->password) {

                // ===== CHECK LOGGED-IN USER PASSWORD =====
                if (!Hash::check($request->confirm_password, auth()->user()->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your password is incorrect. Password change denied.'
                    ], 403);
                }

                // ===== UPDATE PASSWORD =====
                $admin->password = Hash::make($request->password);
                $admin->save();
                // ===== SEND EMAIL TO ADMIN ABOUT PASSWORD CHANGE =====
                $emailData = [
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'password' => $request->password,
                    'loginUrl' => route('admin.login'),
                ];

                Mail::send('email.new-admin', $emailData, function ($message) use ($admin) {
                    $message->to($admin->email)
                            ->subject('Your Admin Password Has Been Updated');
                });

            }

            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = $admin->name . ' Admin details updated.';
            $notification->notification_for = 'Admin';
            $notification->item_id = $admin->id;
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Admin updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function status($id)
    {
        if(Auth::guard('admin')->user()->access->control_panel != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $admin = User::findOrFail($id);

        // TOGGLE STATUS
        $admin->status = $admin->status == 1 ? 2 : 1;
        $admin->save();

        $statusText = $admin->status == 1 ? 'unblocked' : 'blocked';

        $notification = new AdminNotification();
        $notification->admin_id = auth()->id();
        $notification->message = $admin->name . ' Admin has been ' . $statusText . '.';
        $notification->notification_for = 'Admin';
        $notification->item_id = $admin->id;
        $notification->save();

        return back()->with('success', 'Admin User ' . $statusText . ' successfully!');
    }

    public function delete($id)
    {
        if(Auth::guard('admin')->user()->access->control_panel != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $admin = User::findOrFail($id);

        // ===== DELETE ADMIN ACCESS RECORD =====
        AdminAccess::where('admin_id', $admin->id)->delete();

        $notification = new AdminNotification();
        $notification->admin_id = auth()->id();
        $notification->message = $admin->name . ' Admin has been deleted.';
        $notification->notification_for = 'Admin';
        $notification->item_id = $admin->id;
        $notification->save();

        // ===== DELETE ADMIN USER =====
        $admin->delete();

        return back()->with('success', 'Admin User deleted successfully!');
    }

    public static function adminLog(Request $request)
    {
        if (Auth::guard('admin')->user()->access->control_panel == 2) {
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }

        $query = AdminNotification::query();

        // Default last 7 days
        $from = $request->from_date ?? now()->subDays(7)->format('Y-m-d');
        $to   = $request->to_date ?? now()->format('Y-m-d');

        $query->whereBetween('created_at', [
            $from . ' 00:00:00',
            $to . ' 23:59:59'
        ]);

        // Admin filter only if selected
        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        $userlogs = $query->get();

        return view('admin.admin.logs', [
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::find(1),
            'userlogs' => $userlogs,
            'users' => User::where('role', 0)->where('role_type', '!=', 'Super Admin')->where('status', 1)->get(),
        ]);
    }

}
