<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class  Brand extends Model
{
    use HasFactory;
    private static $brand,$image,$imageUrl, $imageNewName,$dir,$slug,$action;

    public static function saveInfo($request, $id=null){
        if ($id != null){
            self::$brand = Brand::find($id);
            self::$action = 'updated';
        }else{
            self::$brand = new Brand();
            self::$action = 'added';
        }

        self::$brand->name = $request->name;
        self::$brand->showHome = $request->showHome;

        if (self::$brand->slug != self::makeSlug($request) ){

            self::$brand->slug = self::makeSlug($request);

        }else{
            self::$brand->slug = self::makeSlug($request);
        }

        if ($request->file('image')){
            if (self::$brand->image){
                if (file_exists(self::$brand->image)){
                    unlink(self::$brand->image);
                }
            }
            self::$brand->image = self::saveImage($request);
        }

        self::$brand->save();

        $successMessage = "Brand has been " . self::$action . " successfully";
        $request->session()->flash('success', $successMessage);

        return self::$brand ;
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
        self::$imageNewName = self::$brand->slug.rand().'.'.self::$image->extension();
        self::$dir = "admin-assets/img/brands/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }

    public static function statusCheck($id){
        self::$brand = Brand::find($id);
        if (self::$brand->status == 1){
            self::$brand->status = 0;
        }else{
            self::$brand->status = 1;
        }

        self::$brand->save();
    }
}
