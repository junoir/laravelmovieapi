<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Episode;

class Season extends Model
{
    protected $fillable = ['serie_id', 'tmdb_id', 'season_number', 'name', 'overview', 'poster_path', 'air_date'];
    
    public function episodes()
    {
        return $this->hasMany(Episode::class)->orderBy('episode_number');
    }
}
