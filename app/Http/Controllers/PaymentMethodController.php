<?php

namespace App\Http\Controllers;

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

            PaymentMethod::saveInfo($request);
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
        PaymentMethod::find($id)->delete($id);
        return redirect(route('payment_methods.index'));
    }
}
