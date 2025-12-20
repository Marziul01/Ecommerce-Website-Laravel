<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Wishlist;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public static function index(){
        return redirect(route('home'));
        if (Auth::check()){
            $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();
        }else{
            $wishlists = Product::get();
        }

        return view('frontend.shop.wishlist',[
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
            'brands' => Brand::orderBy('name', 'ASC')->where('status', '1')->get(),
            'cartContent' => Cart::content(),
            'wishlists' => $wishlists,
        ]);
    }


    public function addToWishlist(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;

            // Check if product already exists in wishlist
            $exists = Wishlist::where('user_id', $userId)->where('product_id', $request->id)->exists();

            if ($exists) {
                Wishlist::where('user_id', $userId)->where('product_id', $request->id)->delete();
                $message = 'Product removed from wishlist';
                $inWishlist = false;
            } else {
                $wishlist = new Wishlist();
                $wishlist->user_id = $userId;
                $wishlist->product_id = $request->id;
                $wishlist->save();
                $message = 'Product added to wishlist';
                $inWishlist = true;
            }

        } else {
            // Handle session wishlist for guest users (adapt as needed)
            $wishlist = session()->get('wishlist', []);

            if (in_array($request->id, $wishlist)) {
                $wishlist = array_diff($wishlist, [$request->id]);
                session()->put('wishlist', $wishlist);
                $message = 'Product removed from wishlist';
                $inWishlist = false;
            } else {
                $wishlist[] = $request->id;
                session()->put('wishlist', $wishlist);
                $message = 'Product added to wishlist';
                $inWishlist = true;
            }
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'inWishlist' => $inWishlist, // Include 'inWishlist' property for icon update
        ]);
    }

    public function getWishlistCount()
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $count = Wishlist::where('user_id', $userId)->count();
        } else {
            // Handle session wishlist count for guest users (adapt as needed)
            $wishlist = session()->get('wishlist', []);
            $count = count($wishlist);
        }

        return response()->json([
            'status' => true,
            'count' => $count
        ]);
    }




}
