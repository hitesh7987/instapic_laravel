<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function user(){
        return $this->belongsTo("App\User");
    }
    public function photo_comment(){
        return $this->hasMany("App\Models\Photo_comment");
    }
    public function latest_comment(){
        return $this->hasOne("App\Models\Photo_comment")->latest();
    }
}
