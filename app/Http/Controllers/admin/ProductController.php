<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
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
use App\Models\QuantityRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->access->product_manage == 2 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

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
        if(Auth::guard('admin')->user()->access->product_manage != 3 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

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

        if(Auth::guard('admin')->user()->access->product_manage != 3 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

        $rules=[
            'name' => 'required',
            'slug' => 'required | unique:products',
            'short_desc' => 'required',
            'full_desc' => 'required',
            'featured_image' => 'required',
            'category_id' => 'required | numeric',
            'is_featured' => 'required',
        ];

        if ($request->has('variations') && count($request->variations['type'] ?? []) > 0) {
            // Add variation field validation
            $rules = array_merge($rules, [
                'variations.type.*' => 'required|string|max:255',
                'variations.buy_price.*' => 'required|numeric|min:0',
                'variations.price.*' => 'required|numeric|min:0',
                'variations.qty.*' => 'required|integer|min:0',
                'variations.compare_price.*' => 'nullable|numeric|min:0',
            ]);
            $data['qty'] = 0;
            $data['price'] = 0;
            $data['purchase_price'] = 0;
        }else{
            $rules = array_merge($rules, [
                'qty' => 'required',
                'price' => 'required|numeric',
                'purchase_price' => 'required|numeric|min:0|lt:price',
            ]);
        }

        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){
            $createdProduct = Product::saveInfo($request);

            $adminNotification = new AdminNotification();
            $adminNotification->admin_id = Auth::guard('admin')->user()->id;
            $adminNotification->item_id = $createdProduct->id;
            $adminNotification->message = 'New Product Created';
            $adminNotification->notification_for = 'Product';
            $adminNotification->save();

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
        if(Auth::guard('admin')->user()->access->product_manage == 2 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

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
            'variationsData' => ProductVariation::where('product_id', $id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::guard('admin')->user()->access->product_manage != 3 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

        $product = Product::find($id);

        $rules=[
            'name' => 'required',
            'short_desc' => 'required',
            'full_desc' => 'required',
            'image' => 'nullable',
            'category_id' => 'required|numeric',
            'is_featured' => 'required',
        ];
        if ($request->has('variations') && count($request->variations['type'] ?? []) > 0) {
            // Add variation field validation
            $rules = array_merge($rules, [
                'variations.type.*' => 'required|string|max:255',
                'variations.buy_price.*' => 'required|numeric|min:0',
                'variations.price.*' => 'required|numeric|min:0',
                'variations.compare_price.*' => 'nullable|numeric|min:0',
            ]);
            $data['price'] = 0;
            $data['purchase_price'] = 0;
        }else{
            $rules = array_merge($rules, [
                'price' => 'required|numeric',
                'purchase_price' => 'required|numeric|min:0|lt:price',
            ]);
        }

        $validator = Validator::make($request->all(),$rules);
        if ($validator->passes()){
//            return $request;
            $updatedProduct = Product::saveInfo($request,$id);

            $adminNotification = new AdminNotification();
            $adminNotification->admin_id = Auth::guard('admin')->user()->id;
            $adminNotification->item_id = $updatedProduct->id;
            $adminNotification->message = $updatedProduct->name . ' Product has been updated';
            $adminNotification->notification_for = 'Product';
            $adminNotification->save();

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
        if(Auth::guard('admin')->user()->access->product_manage != 3 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

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

                $adminNotification = new AdminNotification();
                $adminNotification->admin_id = Auth::guard('admin')->user()->id;
                $adminNotification->item_id = $product->id;
                $adminNotification->message = $product->name . ' Product has been Deleted';
                $adminNotification->notification_for = 'Product';
                $adminNotification->save();

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

    public function viewProduct($id)
    {
        $product = Product::with(['category', 'subCategory', 'brand', 'productVariations', 'productAdditionalInfo'])
            ->findOrFail($id);

        return response()->json($product);
    }

    public static function updateQuantity(Request $request)
    {
        if(Auth::guard('admin')->user()->access->product_manage != 3 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.variation_id' => 'nullable|exists:product_variations,id',
        ]);

        $items = $data['items'];
        $status = auth()->user()->role == 0 ? 2 : 1;

        foreach ($items as $item) {

            $product = Product::find($item['product_id']);

            // ---------------- VARIATION UPDATE ----------------
            if (!empty($item['variation_id'])) {

                $variation = ProductVariation::find($item['variation_id']);

                if (!$variation) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => ["variation_id" => ["Invalid variation"]]
                    ]);
                }

                // Add quantity
                $variation->qty += $item['quantity'];
                $variation->save();

                // Log request
                QuantityRequest::create([
                    'user_id'      => auth()->id(),
                    'product_id'   => $product->id,
                    'variation_id' => $variation->id,
                    'quantity'     => $item['quantity'],
                    'remaining_qty' => $item['quantity'],
                    'buy_price'    => $variation->buy_price,
                    'date'         => now()->toDateString(),
                    'message'      => 'Product variations quantity update',
                    'status'       => $status,
                ]);
                // Always sync main product qty if product has variations
                $product->qty = $product->productVariations()->sum('qty');
                $product->save();
            } 

            // ---------------- MAIN PRODUCT UPDATE ----------------
            else {
                $product->qty += $item['quantity'];
                $product->save();

                QuantityRequest::create([
                    'user_id'      => auth()->id(),
                    'product_id'   => $product->id,
                    'variation_id' => null,
                    'quantity'     => $item['quantity'],
                    'remaining_qty' => $item['quantity'],
                    'buy_price'    => $product->buy_price,
                    'date'         => now()->toDateString(),
                    'message'      => 'Product quantity update',
                    'status'       => $status,
                ]);
            }
        }

        $adminNotification = new AdminNotification();
        $adminNotification->admin_id = Auth::guard('admin')->user()->id;
        $adminNotification->item_id = $product->id;
        $adminNotification->message = $product->name . ' Products quantity has been added';
        $adminNotification->notification_for = 'Product';
        $adminNotification->save();

        return response()->json(['status' => 'success']);
    }

    public function shipments(string $id)
    {
        if(Auth::guard('admin')->user()->access->product_manage == 2 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

        $product = Product::find($id);

        $notifications = DB::table('notifications')->where('read_at', NULL)->get();
        $totalNotification = $notifications->count();

        return view('admin.products.shipments',[
            'admin' => Auth::guard('admin')->user(),
            'categories' => Category::where('status',1)->get(),
            'brands' => Brand::where('status',1)->get(),
            'product' => $product,
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'notifications' => $notifications,
            'totalNotification' => $totalNotification,
            'requests' => QuantityRequest::where('product_id', $id)->orderByDesc('date')->paginate(20),
        ]);
    }

    public function updateShipment(Request $req, $id)
    {
        if(Auth::guard('admin')->user()->access->shipment_manage != 3 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

        // Validate inputs
        $req->validate([
            'buy_price' => 'required|numeric|min:0',
            'quantity'  => 'required|integer|min:0',
        ]);

        // Find shipment
        $shipment = QuantityRequest::findOrFail($id);

        // Store old quantity
        $oldQty = $shipment->quantity;

        // New quantity from form
        $newQty = (int) $req->quantity;

        // Difference calculation
        $difference = $newQty - $oldQty;

        $product = Product::find($shipment->product_id);
        $variation = $shipment->variation_id ? ProductVariation::find($shipment->variation_id) : null;

        // --------- Update Product / Variation Quantities ----------
        // CASE 1: Variation exists
        if ($variation) {

            $variation->quantity += $difference;

            if ($variation->quantity < 0) {
                return back()->with('error', 'Variation quantity cannot be negative.');
            }

            $variation->save();
        }

        // Product quantity update
        if ($product) {
            $product->quantity += $difference;

            if ($product->quantity < 0) {
                return back()->with('error', 'Product quantity cannot be negative.');
            }

            $product->save();
        }

        // --------- Update shipment details ----------
        $shipment->buy_price = $req->buy_price;

        // Update remaining qty safely
        $shipment->remaining_qty += $difference;

        if ($shipment->remaining_qty < 0) {
            return back()->with('error', 'Remaining quantity cannot be negative.');
        }

        $shipment->quantity = $newQty;
        $shipment->save();

        // --------- Admin Notification ----------
        $message = $product->name;

        if ($variation) {
            $message .= ' (' . $variation->type . ')';
        }

        $message .= ' Product Shipment has been Updated';

        $adminNotification = new AdminNotification();
        $adminNotification->admin_id = Auth::guard('admin')->user()->id;
        $adminNotification->item_id = $shipment->id;
        $adminNotification->message = $message;
        $adminNotification->notification_for = 'Product Shipment';
        $adminNotification->save();

        return back()->with('success', 'Shipment updated successfully!');
    }


    public function shipmentDelete(string $id)
    {
        if(Auth::guard('admin')->user()->access->shipment_manage != 3 ){
            return redirect(route('admin.dashboard'))->with('error' , 'Access denied');
        }

        $shipment_manage = QuantityRequest::find($id);
        $variationName = null;
        $productName = null;
        if ($shipment_manage) {
            if ($shipment_manage->variation_id) {
                $variation = ProductVariation::find($shipment_manage->variation_id);
                $variationName = $variation->type;
            }

            if ($shipment_manage->product_id) {
                $product = Product::find($shipment_manage->product_id);
                $productName = $product->name;
            }
                $adminNotification = new AdminNotification();
                $adminNotification->admin_id = Auth::guard('admin')->user()->id;
                $adminNotification->item_id = $shipment_manage->id;

                $message = $productName;

                if ($variationName) {
                    $message .= ' (' . $variationName . ')';
                }

                $message .= ' Product Shipment has been Deleted';

                $adminNotification->message = $message;
                $adminNotification->notification_for = 'Product Shipment';
                $adminNotification->save();


                $shipment_manage->delete();

        }

        return redirect(route('product.index'));
    }


}
