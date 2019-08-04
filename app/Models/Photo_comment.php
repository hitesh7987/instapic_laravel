<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo_comment extends Model
{
    public function photo(){
        return $this->belongsTo("App\Models\Photo");
    }
    public function user(){
        return $this->belongsTo("App\User");
    }
}
