<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    private static $category,$image,$imageUrl, $imageNewName,$dir,$slug,$action;

    public static function saveInfo($request, $id=null){
        if ($id != null){
            self::$category = Slider::find($id);
            self::$action = 'updated';
        }else{
            self::$category = new Slider();
            self::$action = 'added';
        }

        self::$category->link = $request->link;
        

        if ($request->file('image')){
            if (self::$category->image){
                if (file_exists(self::$category->image)){
                    unlink(self::$category->image);
                }
            }
            self::$category->image = self::saveImage($request);
        }

        self::$category->save();

        $successMessage = "Slider has been " . self::$action . " successfully";
        $request->session()->flash('success', $successMessage);

        return self::$category;
    }

    public static function saveImage($request){
        self::$image = $request->file('image');
        self::$imageNewName = 'slider'.rand().'.'.self::$image->extension();
        self::$dir = "admin-assets/img/slider/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }
}
