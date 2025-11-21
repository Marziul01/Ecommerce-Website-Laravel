<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Temp_Image;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\HttpFoundation\Session\Storage\save;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    use HasFactory;
    private static $product,$image,$imageUrl, $imageNewName,$dir,$slug,$action;

    public static function saveInfo($request, $id=null){
        if ($id != null){
            self::$product = Product::find($id);
            self::$action = 'updated';
        }else{
            self::$product = new Product();
            self::$action = 'added';
        }

        self::$product->name = $request->name;

        if (self::$product->slug != self::makeSlug($request) ){

            self::$product->slug = self::makeSlug($request);

        }else{
            self::$product->slug = self::makeSlug($request);
        }

        self::$product->short_desc = $request->short_desc;
        self::$product->full_desc = $request->full_desc;
        self::$product->purchase_price = $request->purchase_price;
        self::$product->price = $request->price;
        self::$product->compare_price = $request->compare_price;
        self::$product->category_id = $request->category_id;
        self::$product->sub_category_id = $request->sub_category_id;
        self::$product->brand_id = $request->brand_id;
        self::$product->sku = $request->sku;
        self::$product->barcode = $request->barcode;
        self::$product->track_qty = $request->track_qty;
        self::$product->qty = $request->qty;
        self::$product->is_featured = $request->is_featured;

        if ($request->file('featured_image')){
            if (self::$product->featured_image){
                if (file_exists(self::$product->featured_image)){
                    unlink(self::$product->featured_image);
                }
            }
            self::$product->featured_image = self::saveImage($request);
        }

        $colors = $request->input('color') ?? [];
        $sizes = $request->input('size') ?? [];

        if (is_array($colors) && is_array($sizes) && count($colors) === count($sizes)) {
            $colorArray = [];
            $sizeArray = [];

            foreach ($colors as $index => $color) {
                $size = $sizes[$index] ?? null; // Use null if size is not set
                $colorArray[] = $color;
                $sizeArray[] = $size;
            }

            // Convert arrays to comma-separated strings
            $colorString = implode(',', $colorArray);
            $sizeString = implode(',', $sizeArray);

            self::$product->colors = $colorString;
            self::$product->sizes = $sizeString;
        }

        self::$product->save();

        if (!empty($request->image_id)) {
            foreach ($request->image_id as $key => $imageId) {
                $tempImage = Temp_Image::find($imageId);

                if ($tempImage) {
                    $extArray = explode('.', $tempImage->images);
                    $ext = last($extArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = self::$product->id;

                    $newImageName = $request->slug .time(). rand(). '.' . $ext;

                    $dir = "admin-assets/img/products/product_images/";
                    $imageUrl = $dir . $newImageName;

                    // Construct the full path to the temporary image
                    $tempDir = "admin-assets/img/products/temp_images/";
                    $tempImagePath = public_path($tempDir . $tempImage->images);

                    // Construct the full path to the permanent location
                    $newImagePath = public_path('admin-assets/img/products/product_images/' . $newImageName);

                    // Move the file from the temporary location to the permanent location
                    if (rename($tempImagePath, $newImagePath)) {
                        $productImage->images = $imageUrl;
                        $productImage->save();

                        // Remove the data from Temp_Image model
                        $tempImage->delete();
                    } else {
                        $request->session()->flash('error', 'Product Gallery is not Submitted');
                    }
                }
            }
            Temp_Image::truncate();
        }

        if ($request->file('colorImage.featured')) {
            $colors = $request->input('variations.color1');
            $colorImages = $request->file('colorImage.featured');  // Use `file()` method to get the files

            foreach ($colorImages as $index => $colorImage) {
                $color = $colors[$index];

                $productVariations = new ProductVariation();
                $productVariations->product_id = self::$product->id;
                $productVariations->color = $color;

                $imageNewName = $color . rand() . '.' . $colorImage->extension();
                $dir = "admin-assets/img/products/product_images/";
                $imageUrl = $dir . $imageNewName;
                $colorImage->move($dir, $imageUrl);

                $productVariations->image = $imageUrl;
                $productVariations->save();
            }
        }
        if ($request->input('information.option')) {
            $options = $request->input('information.option');
            $optionValues = $request->input('information.optionValue');

            foreach ($options as $index => $option) {
                $optionValue = $optionValues[$index];

                $existingOption = ProductAdditionalInfo::where('product_id', $id)
                    ->where('option', $option)
                    ->first();

                if ($existingOption) {
                    // Update existing option
                    $existingOption->optionValue = $optionValue;
                    $existingOption->save();
                } else {
                    // Create new option
                    $information = new ProductAdditionalInfo();
                    $information->product_id = self::$product->id;
                    $information->option = $option;
                    $information->optionValue = $optionValue;
                    $information->save();
                }
            }

            // Delete options that were not included in the update
            ProductAdditionalInfo::where('product_id', $id)
                ->whereNotIn('option', $options)
                ->delete();
        }

        if ($request->colorImages){
            $colorIds1 = $request->input('imageId');
            $colorImages1 = $request->file('colorImages');

            foreach ($colorImages1 as $index => $colorImage1) {
                $colorId1 = $colorIds1[$index];

                $images = ProductVariation::find($colorId1);

                if (file_exists($images->image)){
                    unlink($images->image);
                }

                $imageNewName = $images->color . rand() . '.' . $colorImage1->extension();
                $dir = "admin-assets/img/products/product_images/";
                $imageUrl = $dir . $imageNewName;
                $colorImage1->move($dir, $imageUrl);

                $images->image = $imageUrl;
                $images->save();
            }
        }



        $successMessage = "Product has been " . self::$action . " successfully";
        $request->session()->flash('success', $successMessage);
    }

    public static function makeSlug($request){
        if ($request->slug){
            self::$slug = Str::slug($request->slug, '-');
        }else{
            self::$slug = Str::slug($request->name, '-');
        }
        return self::$slug;
    }
    public static function saveImage($request){
        self::$image = $request->file('featured_image');
        self::$imageNewName = self::$product->slug.rand().'.'.self::$image->extension();
        self::$dir = "admin-assets/img/products/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }

    public static function statusCheck($id){
        self::$product = Product::find($id);
        if (self::$product->status == 1){
            self::$product->status = 0;
        }else{
            self::$product->status = 1;
        }

        self::$product->save();
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function productGallery(){
        return $this->hasMany(ProductImage::class);
    }
    public function productVariations(){
        return $this->hasMany(ProductVariation::class);
    }
    public function productAdditionalInfo(){
        return $this->hasMany(ProductAdditionalInfo::class);
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
