<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\HomeSetting;
use App\Models\Offer;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public static function index(){

        $category1 = HomeSetting::find(4);
        $category1product = $category1->firstCategory;
        $category1products = Category::where('id', $category1product)->where('status', 1)->with('product')->first();

        $category2 = HomeSetting::find(5);
        $category2product = $category2->secondCategory;
        $category2products = Category::where('id', $category2product)->where('status', 1)->with('product')->first();

        $category3 = HomeSetting::find(6);
        $category3product = $category3->thirdCategory;
        $category3products = Category::where('id', $category3product)->where('status', 1)->with('product')->first();

        if (Auth::check()){
            $userId = Auth::user()->id;
        }else{
            $userId = null;
        }

        $mostOrderedProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(8) // Get top 8 most ordered products
            ->get();

        return view('frontend.home.home',[
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
            'popup_model' => Offer::find('1'),
            'offer2' => Offer::where('id', 2)->first(),
            'offer3' => Offer::where('id', 3)->first(),
            'offer4' => Offer::where('id', 4)->first(),
            'offer5' => Offer::where('id', 5)->first(),
            'offer6' => Offer::where('id', 6)->first(),
            'offer7' => Offer::where('id', 7)->first(),
            'offer8' => Offer::where('id', 8)->first(),
            'offer9' => Offer::where('id', 9)->first(),
            'offer10' => Offer::where('id', 10)->first(),
            'homeSettings' => HomeSetting::where('id',1)->first(),
            'slider2' => HomeSetting::where('id',2)->first(),
            'slider3' => HomeSetting::where('id',3)->first(),
            'brands' => Brand::where('status', 1)->where('showHome', 'YES')->get(),
            'sub_category' => SubCategory::where('status', 1)->where('showHome', 'YES')->get(),
            'category1products' => $category1products,
            'category2products' => $category2products,
            'category3products' => $category3products,
            'Products' => Product::where('status', 1)->with('productGallery')->get(),
            'cartContent' => Cart::content(),
            'products' => Product::where('status', 1 )->get(),
            'userId' => $userId,
            'mostOrderedProducts' => $mostOrderedProducts,
            'sliders' => Slider::all(),
        ]);
    }
}
