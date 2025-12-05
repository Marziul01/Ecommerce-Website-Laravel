<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->access->brand == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.brand.manage',[
            'admin' => Auth::guard('admin')->user(),
            'brands' =>  Brand::latest()->paginate(10),
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
        if(Auth::guard('admin')->user()->access->brand != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required | unique:brands',
        ]);
        if ($validator->passes()){

            $brand = Brand::saveInfo($request);

            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A new Brand has been created .';
            $notification->notification_for = 'Brand';
            $notification->item_id = $brand->id;
            $notification->save();

            return redirect(route('brand.index'));

        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Brand::statusCheck($id);
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
        if(Auth::guard('admin')->user()->access->brand != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $brand = Brand::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $brand->id . ',id'
        ]);
        if ($validator->passes()){

            Brand::saveInfo($request,$id);
            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A Brand has been updated .';
            $notification->notification_for = 'Brand';
            $notification->item_id = $brand->id;
            $notification->save();
            return redirect(route('brand.index'));

        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::guard('admin')->user()->access->brand != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $brand = Brand::find($id);

        if ($brand) {
            if (!empty($brand->image)) {
                // Get the image file path
                $imagePath = public_path($brand->image);

                // Check if the image file exists
                if (file_exists($imagePath)) {
                    // Delete the image file
                    unlink($imagePath);
                }

                // Delete the SubCategory record
                $brand->delete();
            }else{
                $brand->delete();
            }

        }

            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A Brand has been deleted .';
            $notification->notification_for = 'Brand';
            $notification->item_id = $brand->id;
            $notification->save();

        return redirect(route('brand.index'));
    }
}
