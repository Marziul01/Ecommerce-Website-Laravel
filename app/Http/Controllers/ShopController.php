<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public static function index(Request $request, $categorySlug=null, $subCategorySlug=null){
        $categorySelected = '';
        $subCategorySelected = '';
        $brandArray = [];



        $products = Product::where('status', '1');
        if (!empty($categorySlug)){
            $category = Category::where('slug', $categorySlug)->first();
            $products = Product::where('category_id', $category->id);
            $categorySelected = $category->id;
        }
        if (!empty($subCategorySlug)){
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = Product::where('sub_category_id', $subCategory->id);
            $subCategorySelected = $subCategory->id;
        }

        if (!empty($request->get('brand'))){
            $brandArray = explode(',',$request->get('brand'));
            $products = $products->whereIn('brand_id', $brandArray);
        }

        if ($request->get('price_max') != '' && $request->get('price_min') != ''){
            if ($request->get('price_max') == 10000){
                $products = $products->whereBetween('price', [intval($request->get('price_min')), 100000000]);
            }else{
                $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);

            }
        }
        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest'){
                $products = $products->orderBy('id', 'desc');
            }elseif ($request->get('sort') == 'featured'){
                $products = $products->where('is_featured', 'YES');
                $products = $products->orderBy('id', 'desc');
            }elseif ($request->get('sort') == 'low'){
                $products = $products->orderBy('price', 'ASC');
            }else{
                $products = $products->orderBy('price', 'DESC');
            }
        }else{
            $products = $products->orderBy('id', 'desc');
        }


        if ($request->get('show') != '') {
            if ($request->get('show') == 50){
                $products = $products->paginate(1);
            }elseif ($request->get('show') == 100){
                $products = $products->paginate(2);
            }elseif ($request->get('show') == 150){
                $products = $products->paginate(3);
            }elseif ($request->get('show') == 200){
                $products = $products->paginate(4);
            }else{
                $all = $products->count();
                $products = $products->paginate($all);
            }
        }else{
            $products = $products->paginate(12);
        }

        if (Auth::check()){
            $userId = Auth::user()->id;
        }else{
            $userId = null;
        }

        if (!empty($request->get('search'))){
            $products = Product::where('name', 'like', '%'. $request->get('search') .'%')->paginate(12);
        }


        return view('frontend.shop.shop',[
            'siteSettings' => SiteSetting::where('id', 1)->first(),
            'categories' => Category::orderBy('name', 'ASC')->where('status', '1')->with('sub_category')->get(),
            'brands' => Brand::orderBy('name', 'ASC')->where('status', '1')->get(),
            'products' => $products,
            'categorySelected' => $categorySelected,
            'subCategorySelected' => $subCategorySelected,
            'brandsArray' => $brandArray,
            'priceMin' => intval($request->get('price_min')),
            'priceMax' => (intval($request->get('price_max')) == 0) ? 10000 : intval($request->get('price_max')),
            'sort' => $request->get('sort'),
            'show' => $request->get('show'),
            'cartContent' => Cart::content(),
            'userId' => $userId,
        ]);
    }
}
