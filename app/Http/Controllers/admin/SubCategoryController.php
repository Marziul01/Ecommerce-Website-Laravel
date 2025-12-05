<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->access->category == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.sub_category.manage',[
            'admin' => Auth::guard('admin')->user(),
            'categories' =>  Category::where('status',1)->get(),
            'subcategories' => SubCategory::latest()->paginate(10),
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
        if(Auth::guard('admin')->user()->access->category != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $validator = Validator::make($request->all(),[
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required | unique:sub_categories'
        ]);
        if ($validator->passes()){

            $subcategory = SubCategory::saveInfo($request);
            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A new sub category created .';
            $notification->notification_for = 'Sub Category';
            $notification->item_id = $subcategory->id;
            $notification->save();
            return redirect(route('subcategory.index'));

        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        SubCategory::statusCheck($id);
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
        if(Auth::guard('admin')->user()->access->category != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $subcategory = SubCategory::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,' . $subcategory->id . ',id'
        ]);
        if ($validator->passes()){

            SubCategory::saveInfo($request,$id);
            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A sub category updated .';
            $notification->notification_for = 'Sub Category';
            $notification->item_id = $subcategory->id;
            $notification->save();
            return redirect(route('subcategory.index'));

        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::guard('admin')->user()->access->category != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $subcategory = SubCategory::find($id);

        if ($subcategory) {
            if (!empty($subcategory->image)) {
                // Get the image file path
                $imagePath = public_path($subcategory->image);

                // Check if the image file exists
                if (file_exists($imagePath)) {
                    // Delete the image file
                    unlink($imagePath);
                }

                // Delete the SubCategory record
                $subcategory->delete();
            }else{
                $subcategory->delete();
            }

        }
        $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A sub category deleted .';
            $notification->notification_for = 'Sub Category';
            $notification->item_id = $subcategory->id;
            $notification->save();
        return redirect(route('subcategory.index'));
    }

}
