<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'price',
        'qty',
        'buy_price',
        'compare_price'
    ];

    public static function updateInfo($request){
        $ids = $request->id;
        $productIds = $request->product_id;
        $colors = $request->color;
        $sizes = $request->size;
        $qtys = $request->qty;
        $images = $request->image;

        foreach ($ids as $index => $id) {
            $productId = $productIds[$index];
            $color = $colors[$index];
            $size = $sizes[$index];
            $qty = $qtys[$index];


            $variation = ProductVariation::find($id);
            $variation->product_id = $productId;
            $variation->color = $color;
            $variation->size = $size;
            $variation->qty = $qty;

            if ($request->image){
                $image = $images[$index];
                $imageNewName = $color . rand() . '.' . $image->extension();
                $dir = "admin-assets/img/products/product_images/";
                $imageUrl = $dir . $imageNewName;
                $image->move($dir, $imageUrl);

                $variation->image = $imageUrl;
            }

            $variation->save();

            $successMessage = "Product variation has been updated successfully";
            $request->session()->flash('success', $successMessage);
        }
    }

    public static function updateColorImage($request, $productId){
        $colorImages = $request->input('imageId');
        $colorImages = $request->file('colorImage.featured');

    }

}
