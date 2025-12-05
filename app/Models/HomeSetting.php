<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    private static $homeSetting,$image, $imageNewName, $dir, $imageUrl;

    public static function updateInfo($request){
        self::$homeSetting = HomeSetting::find($request->id);
        self::$homeSetting->title = $request->title;
        self::$homeSetting->subtitle = $request->subtitle;
        self::$homeSetting->details = $request->details;
        self::$homeSetting->detailsColor = $request->detailsColor;
        self::$homeSetting->color = $request->color;
        self::$homeSetting->description = $request->description;
        self::$homeSetting->offerText = $request->offerText;
        self::$homeSetting->offerLink = $request->offerLink;
        self::$homeSetting->firstCategory = $request->firstCategory;
        self::$homeSetting->secondCategory = $request->secondCategory;
        self::$homeSetting->thirdCategory = $request->thirdCategory;
        if ($request->file('image')){
            if (self::$homeSetting->image){
                if (file_exists(self::$homeSetting->image)){
                    unlink(self::$homeSetting->image);
                }
            }
            self::$homeSetting->image = self::saveImage($request);
        }
        self::$homeSetting->save();
        $request->session()->flash('success', 'Settings has been saved successfully');
        return self::$homeSetting;
    }

    public static function saveImage($request){
        self::$image = $request->file('image');
        self::$imageNewName = rand().'.'.self::$image->extension();
        self::$dir = "frontend-assets/imgs/slider/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }

    public static function statusCheck($id){
        self::$homeSetting = HomeSetting::find($id);
        if (self::$homeSetting->status == 1){
            self::$homeSetting->status = 0;
        }else{
            self::$homeSetting->status = 1;
        }

        self::$homeSetting->save();
    }

}
