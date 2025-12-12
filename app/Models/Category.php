<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    private static $category,$image,$imageUrl, $imageNewName,$dir,$slug,$action;

    public static function saveInfo($request, $id=null){
        if ($id != null){
            self::$category = Category::find($id);
            self::$action = 'updated';
        }else{
            self::$category = new Category();
            self::$action = 'added';
        }

        self::$category->name = $request->name;
        self::$category->showHome = $request->showHome;

        if (self::$category->slug != self::makeSlug($request) ){

            self::$category->slug = self::makeSlug($request);

        }else{
            self::$category->slug = self::makeSlug($request);
        }

        if ($request->file('image')){
            if (self::$category->image){
                if (file_exists(self::$category->image)){
                    unlink(self::$category->image);
                }
            }
            self::$category->image = self::saveImage($request);
        }

        self::$category->save();

        $successMessage = "Category has been " . self::$action . " successfully";
        $request->session()->flash('success', $successMessage);
        return self::$category; // <-- IMPORTANT
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
        self::$imageNewName = self::$category->slug.rand().'.'.self::$image->extension();
        self::$dir = "admin-assets/img/category/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }

    public static function statusCheck($id){
        self::$category = Category::find($id);
        if (self::$category->status == 1){
            self::$category->status = 0;
        }else{
            self::$category->status = 1;
        }

        self::$category->save();
        
    }

    public function sub_category(){
        return $this->hasMany(SubCategory::class);
    }

    public function product(){
        return $this->hasMany(Product::class);
    }

}



