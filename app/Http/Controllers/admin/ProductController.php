<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\SiteSetting;
use App\Models\SubCategory;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductAdditionalInfo;

class ProductController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = DB::table('notifications')->where('read_at', NULL)->get();
        $totalNotification = $notifications->count();

        return view('admin.products.manage',[
            'admin' => Auth::guard('admin')->user(),
            'products' => Product::latest()->paginate(10),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'notifications' => $notifications,
            'totalNotification' => $totalNotification,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $notifications = DB::table('notifications')->where('read_at', NULL)->get();
        $totalNotification = $notifications->count();

        return view('admin.products.create',[
            'admin' => Auth::guard('admin')->user(),
            'categories' => Category::where('status',1)->get(),
            'brands' => Brand::where('status',1)->get(),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'colors' =>  Variation::whereNotNull('color')->where('status', 1)->get(),
            'sizes' =>  Variation::whereNotNull('size')->where('status', 1)->get(),
            'notifications' => $notifications,
            'totalNotification' => $totalNotification,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules=[
            'name' => 'required',
            'slug' => 'required | unique:products',
            'short_desc' => 'required',
            'full_desc' => 'required',
            'featured_image' => 'required',
            'purchase_price' => 'required | numeric',
            'price' => 'required | numeric',
            'sku' => 'required | unique:products',
            'track_qty' => 'required | in:YES,NO',
            'category_id' => 'required | numeric',
            'is_featured' => 'required',
        ];
        if (!empty($request->track_qty) && $request->track_qty == 'YES'){
            $rules['qty'] = 'required | numeric';
        }

        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){
//            return $request;
            Product::saveInfo($request);
            return redirect(route('product.index'));

        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Product::statusCheck($id);
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $selectedColors = explode(',', $product->colors);
        $selectedSizes = explode(',', $product->sizes);

        $notifications = DB::table('notifications')->where('read_at', NULL)->get();
        $totalNotification = $notifications->count();

        return view('admin.products.edit',[
            'admin' => Auth::guard('admin')->user(),
            'categories' => Category::where('status',1)->get(),
            'brands' => Brand::where('status',1)->get(),
            'productImages' => ProductImage::where('product_id',$id)->get(),
            'product' => Product::find($id),
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'colors' =>  Variation::whereNotNull('color')->where('status', 1)->get(),
            'sizes' =>  Variation::whereNotNull('size')->where('status', 1)->get(),
            'existingData' => ProductAdditionalInfo::where('product_id', $id)->get(),
            'existingVariations' => ProductVariation::where('product_id', $id)->get(),
            'selectedColors' => $selectedColors,
            'selectedSizes' => $selectedSizes,
            'notifications' => $notifications,
            'totalNotification' => $totalNotification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        $rules=[
            'name' => 'required',
            'slug' => 'required | unique:products,slug,' . $product->id . ',id',
            'short_desc' => 'required',
            'full_desc' => 'required',
            'price' => 'required | numeric',
            'purchase_price' => 'required | numeric',
            'image' => 'nullable',
            'sku' => 'required | unique:products,sku,'.$product->id.',id',
            'track_qty' => 'required | in:YES,NO',
            'category_id' => 'required | numeric',
            'is_featured' => 'required',
        ];
        if (!empty($request->track_qty) && $request->track_qty == 'YES'){
            $rules['qty'] = 'required | numeric';
        }

        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){
//            return $request;
            Product::saveInfo($request,$id);
            return redirect(route('product.index'));

        }else{
            return back()->withErrors($validator);
        }
    }

    public function variationUpdate(Request $request){
        ProductVariation::updateInfo($request);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            if (!empty($product->featured_image)) {
                // Get the image file path
                $imagePath = public_path($product->featured_image);

                // Check if the image file exists
                if (file_exists($imagePath)) {
                    // Delete the image file
                    unlink($imagePath);
                }

                // Delete the SubCategory record
                $product->delete();
            }else{
                $product->delete();
            }

        }

        return redirect(route('product.index'));
    }
    public function colorImageDelete($id){

        $image = ProductVariation::find($id);

        if ($image) {
            if (!empty($image->image)) {
                // Get the image file path
                $imagePath = public_path($image->image);

                // Check if the image file exists
                if (file_exists($imagePath)) {
                    // Delete the image file
                    unlink($imagePath);
                }

                // Delete the SubCategory record
                $image->delete();
            }else{
                $image->delete();
            }

        }

        return back();

    }


}
