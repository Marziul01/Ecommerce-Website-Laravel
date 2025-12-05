<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use function Laravel\Prompts\search;

class SubCategory extends Model
{
    use HasFactory;
    private static $subcategory,$image,$imageUrl, $imageNewName,$dir,$slug,$action;

    public static function saveInfo($request, $id=null){
        if ($id != null){
            self::$subcategory = SubCategory::find($id);
            self::$action = 'updated';
        }else{
            self::$subcategory = new SubCategory();
            self::$action = 'added';
        }

        self::$subcategory->name = $request->name;
        self::$subcategory->showHome = $request->showHome;
        self::$subcategory->category_id = $request->category_id;

        if (self::$subcategory->slug != self::makeSlug($request) ){

            self::$subcategory->slug = self::makeSlug($request);

        }else{
            self::$subcategory->slug = self::makeSlug($request);
        }

        if ($request->file('image')){
            if (self::$subcategory->image){
                if (file_exists(self::$subcategory->image)){
                    unlink(self::$subcategory->image);
                }
            }
            self::$subcategory->image = self::saveImage($request);
        }
        if ($request->file('sizeImage')){
            if (self::$subcategory->size_chart){
                if (file_exists(self::$subcategory->size_chart)){
                    unlink(self::$subcategory->size_chart);
                }
            }
            self::$subcategory->size_chart = self::saveSizeImage($request);
        }

        self::$subcategory->save();

        $successMessage = "Subcategory has been " . self::$action . " successfully";
        $request->session()->flash('success', $successMessage);

        return self::$subcategory;
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
        self::$image = $request->file('image');
        self::$imageNewName = self::$subcategory->slug.rand().'.'.self::$image->extension();
        self::$dir = "admin-assets/img/sub_category/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }

    public static function saveSizeImage($request){
        self::$image = $request->file('sizeImage');
        self::$imageNewName = self::$subcategory->slug.'sizeChart'.rand().'.'.self::$image->extension();
        self::$dir = "admin-assets/img/sub_category/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }

    public static function statusCheck($id){
        self::$subcategory = SubCategory::find($id);
        if (self::$subcategory->status == 1){
            self::$subcategory->status = 0;
        }else{
            self::$subcategory->status = 1;
        }

        self::$subcategory->save();
    }

    public function category(){
       return $this->belongsTo(Category::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }
}
