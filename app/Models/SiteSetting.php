<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;
    private static $setting,$image, $imageNewName, $dir, $imageUrl, $action;

    public static function updateInfo($request){
        self::$setting = SiteSetting::find($request->id);
        self::$action = 'saved';
        if ($request->file('logo')){
            if (self::$setting->logo){
                if (file_exists(self::$setting->logo)){
                    unlink(self::$setting->logo);
                }
            }
            self::$setting->logo = self::saveLogo($request);
        }
        if ($request->file('favicon')){
            if (self::$setting->favicon){
                if (file_exists(self::$setting->favicon)){
                    unlink(self::$setting->favicon);
                }
            }
            self::$setting->favicon = self::saveFavicon($request);
        }

        self::$setting->title = $request->title;
        self::$setting->tagline = $request->tagline;

        self::$setting->save();

        $successMessage = "Site Settings has been " . self::$action . " successfully";
        $request->session()->flash('success', $successMessage);

        return self::$setting;
    }

    public static function updateHeader($request){
        self::$setting = SiteSetting::find($request->id);
        self::$setting->phone = $request->phone;
        self::$setting->locationLink = $request->locationLink;
        self::$setting->offerOne = $request->offerOne;
        self::$setting->offerOneLink = $request->offerOneLink;
        self::$setting->offerTwo = $request->offerTwo;
        self::$setting->offerTwoLink = $request->offerTwoLink;
        self::$setting->hotline = $request->hotline;
        self::$setting->save();
        $request->session()->flash('success', 'Header Settings has been saved successfully');
        return self::$setting;
    }

    public static function updateFooter($request){
        self::$setting = SiteSetting::find($request->id);
        self::$setting->appStoreLink = $request->appStoreLink;
        self::$setting->googleStoreLink = $request->googleStoreLink;
        self::$setting->address = $request->address;
        self::$setting->email = $request->email;
        self::$setting->facebook = $request->facebook;
        self::$setting->twitter = $request->twitter;
        self::$setting->instagram = $request->instagram;
        self::$setting->youtube = $request->youtube;

        if ($request->file('paymentImage')){
            if (self::$setting->paymentImage){
                if (file_exists(self::$setting->paymentImage)){
                    unlink(self::$setting->paymentImage);
                }
            }
            self::$setting->paymentImage = self::savePaymentImage($request);
        }
        self::$setting->save();
        $request->session()->flash('success', 'Footer Settings has been saved successfully');
        return self::$setting;
    }


    public static function saveLogo($request){
        self::$image = $request->file('logo');
        self::$imageNewName = "logo".'.'.self::$image->extension();
        self::$dir = "frontend-assets/imgs/theme/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }
    public static function saveFavicon($request){
        self::$image = $request->file('favicon');
        self::$imageNewName = "favicon".'.'.self::$image->extension();
        self::$dir = "frontend-assets/imgs/theme/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }
    public static function savePaymentImage($request){
        self::$image = $request->file('paymentImage');
        self::$imageNewName = "paymentNewImage".'.'.self::$image->extension();
        self::$dir = "frontend-assets/imgs/theme/";
        self::$imageUrl = self::$dir.self::$imageNewName;
        self::$image->move(self::$dir,self::$imageUrl);
        return self::$imageUrl;
    }

}
