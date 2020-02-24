<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [];
    
    public function movies() {
        return $this->hasMany('App\MovieGenre');
    }
    
    public function series() {
        return $this->hasMany('App\SerieGenre');
    }

}
