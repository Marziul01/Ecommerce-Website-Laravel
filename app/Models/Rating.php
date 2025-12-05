<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public static function saveInfo($request,$id=null){
        if ($id != null){
            $rating = Rating::find($id);
        }else{
            $rating = new Rating();
        }
        $rating->product_id = $request->product_id;
        $rating->name = $request->name;
        $rating->email = $request->email;
        $rating->comment = $request->comment;
        $rating->rating = $request->rating;
        $rating->save();

        $successMessage = "Your Review submitted successfully";
        $request->session()->flash('success', $successMessage);

        return $rating;
    }

    public static function statusCheck($id){
        $rating = Rating::find($id);
        if ($rating->status == 1){
            $rating->status = 0;
        }else{
            $rating->status = 1;
        }
        $rating->save();

        return $rating;
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
