<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Temp_Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    private static $product,$image,$imageUrl, $imageNewName,$dir,$slug,$action;

    public static function saveInfo($request, $id = null)
    {
        // Start transaction so partial writes won't corrupt data
        DB::beginTransaction();
        try {
            // Determine create vs update
            if ($id !== null) {
                self::$product = Product::findOrFail($id);
                self::$action = 'updated';
            } else {
                self::$product = new Product();
                self::$action = 'added';
            }

            // -----------------------
            //  SKU (unique)
            // -----------------------
            $inputSku = $request->input('sku');
            if ($inputSku) {
                // If updating, exclude current product from uniqueness check
                $skuExists = Product::where('sku', $inputSku)
                    ->when($id !== null, fn($q) => $q->where('id', '!=', $id))
                    ->exists();

                if ($skuExists) {
                    // You can change this to throw ValidationException if desired
                    $request->session()->flash('error', 'Provided SKU already exists.');
                    DB::rollBack();
                    return false;
                }
                self::$product->sku = $inputSku;
            } else {
                // generate 4-digit unique SKU (keeps trying until unique)
                do {
                    $generated = rand(1000, 9999);
                    $exists = Product::where('sku', $generated)
                        ->when($id !== null, fn($q) => $q->where('id', '!=', $id))
                        ->exists();
                } while ($exists);
                self::$product->sku = $generated;
            }

            // -----------------------
            // Basic product fields
            // -----------------------
            self::$product->name = $request->input('name');
            self::$product->short_desc = $request->input('short_desc');
            self::$product->full_desc = $request->input('full_desc');
            self::$product->purchase_price = $request->input('purchase_price') ?? 0;
            self::$product->price = $request->input('price') ?? 0;
            self::$product->compare_price = $request->input('compare_price') ?? null;
            self::$product->category_id = $request->input('category_id') ?? null;
            self::$product->sub_category_id = $request->input('sub_category_id') ?? null;
            self::$product->brand_id = $request->input('brand_id') ?? null;
            self::$product->track_qty = $request->input('track_qty');
            self::$product->is_featured = $request->input('is_featured');

            // -----------------------
            // Slug (unique)
            // -----------------------
            $desiredSlug = $request->input('slug') ? Str::slug($request->input('slug')) : Str::slug($request->input('name'));
            self::$product->slug = self::makeUniqueSlug($desiredSlug, $id);

            // -----------------------
            // Quantity logic (variations sum or single qty)
            // -----------------------
            $newTotalQty = 0;
            $variationQtys = $request->input('variations.qty', null);
            if (is_array($variationQtys) && count($variationQtys) > 0) {
                foreach ($variationQtys as $q) {
                    $newTotalQty += intval($q);
                }
                self::$product->qty = $newTotalQty;
            } else {
                self::$product->qty = intval($request->input('qty', 0));
            }

            // -----------------------
            // Featured image handling
            // -----------------------
            if ($request->hasFile('featured_image')) {
                // remove old image file if exists
                if (!empty(self::$product->featured_image)) {
                    $oldPath = public_path(self::$product->featured_image);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }
                // save new image
                self::$product->featured_image = self::saveImage($request);
            }

            // Save product BEFORE working on relations that require product->id
            self::$product->save();

            // -----------------------
            // Gallery images (Temp_Image -> ProductImage)
            // -----------------------
            $imageIds = $request->input('image_id', []);
            if (!empty($imageIds) && is_array($imageIds)) {
                $tempDir = 'admin-assets/img/products/temp_images/';
                $destDir = 'admin-assets/img/products/product_images/';
                foreach ($imageIds as $imageId) {
                    $tempImage = Temp_Image::find($imageId);
                    if (!$tempImage) {
                        continue;
                    }

                    $originalFilename = $tempImage->images; // assuming this is filename stored
                    $ext = pathinfo($originalFilename, PATHINFO_EXTENSION);
                    $newImageName = self::$product->slug . '_' . time() . '_' . rand(1000, 9999) . '.' . $ext;

                    $tempImagePath = public_path($tempDir . $originalFilename);
                    $newImagePath = public_path($destDir . $newImageName);

                    // Move file (use rename or File::move)
                    if (File::exists($tempImagePath)) {
                        File::move($tempImagePath, $newImagePath);

                        $productImage = new ProductImage();
                        $productImage->product_id = self::$product->id;
                        $productImage->images = $destDir . $newImageName;
                        $productImage->save();

                        // remove temp db row
                        $tempImage->delete();
                    } else {
                        // if the file wasn't found, flash warning but continue
                        $request->session()->flash('warning', 'One of temp images was not found and skipped.');
                    }
                }
                // DO NOT truncate the entire Temp_Image table (unsafe). We only removed those we processed.
            }

            // -----------------------
            // Additional information (option => optionValue)
            // -----------------------
            $options = $request->input('information.option', []);
            $optionValues = $request->input('information.optionValue', []);
            if (is_array($options) && count($options) > 0) {
                $keptOptions = [];
                foreach ($options as $index => $option) {
                    $optionValue = $optionValues[$index] ?? null;
                    $keptOptions[] = $option;

                    $existing = ProductAdditionalInfo::where('product_id', self::$product->id)
                        ->where('option', $option)
                        ->first();

                    if ($existing) {
                        $existing->optionValue = $optionValue;
                        $existing->save();
                    } else {
                        $info = new ProductAdditionalInfo();
                        $info->product_id = self::$product->id;
                        $info->option = $option;
                        $info->optionValue = $optionValue;
                        $info->save();
                    }
                }

                // delete options that were removed by user
                ProductAdditionalInfo::where('product_id', self::$product->id)
                    ->whereNotIn('option', $keptOptions)
                    ->delete();
            } else {
                // if no options provided, remove all additional info for this product
                ProductAdditionalInfo::where('product_id', self::$product->id)->delete();
            }

            // -----------------------
            // Variations (create/update/delete)
            // Expecting arrays at:
            //   variations.type
            //   variations.price
            //   variations.qty
            //   variations.buy_price
            // -----------------------
            $types = $request->input('variations.type', []);
            $prices = $request->input('variations.price', []);
            $qtys = $request->input('variations.qty', []);
            $buy_prices = $request->input('variations.buy_price', []);
            $sale_prices = $request->input('variations.compare_price', []);
            if (is_array($types) && count($types) > 0) {
                $keptVariationIds = [];
                foreach ($types as $index => $type) {
                    $type = trim($type);
                    if ($type === '') continue;

                    $price = isset($prices[$index]) ? floatval($prices[$index]) : 0;
                    $qty = isset($qtys[$index]) ? intval($qtys[$index]) : 0;
                    $buy_price = isset($buy_prices[$index]) ? floatval($buy_prices[$index]) : 0;
                    $sale_price = isset($sale_prices[$index]) ? floatval($sale_prices[$index]) : 0;
                    // Check if variation already exists
                    $variation = ProductVariation::where('product_id', self::$product->id)
                        ->where('type', $type)
                        ->first();

                    if ($variation) {
                        // Existing variation: just update
                        $variation->price = $price;
                        $variation->qty = $qty;
                        $variation->buy_price = $buy_price;
                        $variation->compare_price = $sale_price;
                        $variation->save();
                    } else {
                        // New variation: create
                        $variation = ProductVariation::create([
                            'product_id' => self::$product->id,
                            'type' => $type,
                            'price' => $price,
                            'qty' => $qty,
                            'buy_price' => $buy_price,
                            'compare_price' => $sale_price,
                        ]);

                        // Create QuantityRequest only for **newly created variation**
                        $qtyRequest = new QuantityRequest();
                        $qtyRequest->product_id = self::$product->id;
                        $qtyRequest->variation_id = $variation->id;
                        $qtyRequest->user_id = auth()->id();
                        $qtyRequest->buy_price = $variation->buy_price;
                        $qtyRequest->quantity = $variation->qty;
                        $qtyRequest->remaining_qty = $variation->qty;
                        $qtyRequest->date = $variation->created_at ?? now();
                        $qtyRequest->status = (auth()->user()->role == 0) ? 2 : 1;
                        $qtyRequest->message = 'New Product Variation added: ' . $type;
                        $qtyRequest->save();
                    }

                    $keptVariationIds[] = $variation->id;
                }

                // Remove deleted variations
                ProductVariation::where('product_id', self::$product->id)
                    ->whereNotIn('id', $keptVariationIds)
                    ->delete();
            } else {
                // No variations
                ProductVariation::where('product_id', self::$product->id)->delete();

                $qtyRequest = new QuantityRequest();
                $qtyRequest->product_id = self::$product->id;
                $qtyRequest->variation_id = null;
                $qtyRequest->user_id = auth()->id();
                $qtyRequest->buy_price = self::$product->buy_price ?? 0;
                $qtyRequest->quantity = self::$product->qty ?? 0;
                $qtyRequest->remaining_qty = self::$product->qty ?? 0;
                $qtyRequest->date = self::$product->created_at ?? now();
                $qtyRequest->status = (auth()->user()->role == 0) ? 2 : 1;
                $qtyRequest->message = 'New Products Added/Updated';
                $qtyRequest->save();
            }


            // Finalize
            DB::commit();
            $request->session()->flash('success', 'Product has been ' . self::$action . ' successfully');
            return self::$product;
        } catch (\Exception $e) {
            DB::rollBack();
            // log error for debugging
            Log::error('Product saveInfo error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $request->session()->flash('error', 'An error occurred while saving the product.');
            return false;
        }
    }

    /**
     * makeUniqueSlug - ensures slug uniqueness across products
     */
    public static function makeUniqueSlug(string $desiredSlug, $excludeId = null): string
    {
        $base = Str::slug($desiredSlug);
        $slug = $base;
        $i = 1;

        while (Product::where('slug', $slug)->when($excludeId !== null, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

    /**
     * saveImage - saves uploaded featured image correctly and returns stored path
     */
    public static function saveImage($request)
    {
        if (!$request->hasFile('featured_image')) {
            return null;
        }

        $image = $request->file('featured_image');
        $ext = $image->getClientOriginalExtension();
        $dir = 'admin-assets/img/products/';
        $imageName = self::$product->slug . '_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
        $destinationPath = public_path($dir);

        // Ensure directory exists
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Move file to public directory
        $image->move($destinationPath, $imageName);

        return $dir . $imageName;
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
        return $this->hasMany(ProductVariation::class ,'product_id');
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
