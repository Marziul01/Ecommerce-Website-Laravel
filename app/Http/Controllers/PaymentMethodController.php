<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\PaymentMethod;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->access->payment_methods == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.payemnt.payment',[
            'admin' => Auth::guard('admin')->user(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'PaymentMethods' => PaymentMethod::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        if(Auth::guard('admin')->user()->access->payment_methods != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $validator = Validator::make($request->all(),[
            'type' => 'required',
            'name' => 'required| unique:payment_methods',
            'number' => [
                'nullable',
                'required_unless:type,COD', // Correct rule for your scenario
                'numeric',
            ],
            'account_name' => 'nullable|required_if:type,Bank Account|string|max:255',
            'bank_name' => 'nullable|required_if:type,Bank Account|string|max:255',
            'branch_name' => 'nullable|required_if:type,Bank Account|string|max:255',
            'note' => 'nullable',
        ]);
        if ($validator->passes()){

            $payment_methods = PaymentMethod::saveInfo($request);
            $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = $payment_methods->name .' Payment method has been created .';
                $notification->notification_for = 'Payment Method';
                $notification->item_id = $payment_methods->id;
                $notification->save();
            return redirect(route('payment_methods.index'));

        }else{
            return back()->withErrors($validator);
        }
    }

    
    public function show(string $id)
    {
        PaymentMethod::statusCheck($id);
        return back();
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
        if(Auth::guard('admin')->user()->access->payment_methods != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $payment_methods = PaymentMethod::find($id);
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'name' => 'required|unique:payment_methods,name,' . $payment_methods->id . ',id',
            'number' => [
                'nullable',
                'required_unless:type,COD', // Correct rule for your scenario
                'numeric',
            ],
            'account_name' => 'nullable|required_if:type,Bank Account|string|max:255',
            'bank_name' => 'nullable|required_if:type,Bank Account|string|max:255',
            'branch_name' => 'nullable|required_if:type,Bank Account|string|max:255',
            'note' => 'nullable',
        ]);
        if ($validator->passes()){

            PaymentMethod::saveInfo($request,$id);
            $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = $payment_methods->name .' Payment method has been updated .';
                $notification->notification_for = 'Payment Method';
                $notification->item_id = $payment_methods->id;
                $notification->save();
            return redirect(route('payment_methods.index'));

        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::guard('admin')->user()->access->payment_methods != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        PaymentMethod::find($id)->delete($id);
        $notification = new AdminNotification();
                $notification->admin_id = auth()->id();
                $notification->message = 'A Payment method has been deleted .';
                $notification->notification_for = 'Payment Method';
                $notification->item_id = $id;
                $notification->save();
        return redirect(route('payment_methods.index'));
    }
}
