<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    private static $setting,$image, $imageNewName, $dir, $imageUrl;

    public static function updateInfo($request){

        self::$setting = Page::find($request->id);

        self::$setting->content = $request->content;

        if ($request->file('image')){
            if (self::$setting->image){
                if (file_exists(self::$setting->image)){
                    unlink(self::$setting->image);
                }
            }
            self::$setting->image = self::saveImage($request);
        }

        self::$setting->save();
        $request->session()->flash('success', 'Page settings has been saved successfully');

        return self::$setting;
    }

    public static function saveImage($request){
        self::$image = $request->file('image');
        self::$imageNewName = rand().'.'.self::$image->extension();
        self::$dir = "admin-assets/img/page_settings/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }

}
