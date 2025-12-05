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

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->access->category == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.category.manage',[
            'admin' => Auth::guard('admin')->user(),
            'categories' =>  Category::latest()->paginate(10),
            'siteSettings' => SiteSetting::where('id', 1)->first()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
            'name' => 'required',
            'slug' => 'required | unique:categories',
        ]);
        if ($validator->passes()){

            $category = Category::saveInfo($request);

            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A new category created .';
            $notification->notification_for = 'Category';
            $notification->item_id = $category->id;
            $notification->save();

            return redirect(route('category.index'));

        }else{
            return back()->withErrors($validator);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Category::statusCheck($id);
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
        $category = Category::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $category->id . ',id'
        ]);
        if ($validator->passes()){

            Category::saveInfo($request,$id);

            $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A category updated.';
            $notification->notification_for = 'Category';
            $notification->item_id = $category->id;
            $notification->save();

            return redirect(route('category.index'));

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
        $category = Category::find($id);

        if ($category) {
            if (!empty($category->image)) {
                // Get the image file path
                $imagePath = public_path($category->image);

                // Check if the image file exists
                if (file_exists($imagePath)) {
                    // Delete the image file
                    unlink($imagePath);
                }
                
                // Delete the SubCategory record
                $category->delete();
            }else{
                $category->delete();
            }

        }

        $notification = new AdminNotification();
            $notification->admin_id = auth()->id();
            $notification->message = 'A category deleted.';
            $notification->notification_for = 'Category';
            $notification->item_id = $category->id;
            $notification->save();

        return redirect(route('category.index'));
    }
}
