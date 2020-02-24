<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['tmdb_id', 'title', 'overview', 'poster_path', 'backdrop_path', 'preview_path', 'vote_average', 'vote_count', 'popularity', 'release_date'];
    protected $appends = ['hd', 'genreslist'];

    public function genres() {
        return $this->hasMany('App\MovieGenre');
    }

    public function videos() {
        return $this->hasMany('App\MovieVideo');
    }

    public function getHdAttribute() 
    {
        $hd = 0;
        $videos = $this->videos;
        if($videos) {
            foreach($videos as $video){
                if($video->hd){
                    $hd = 1;
                }
            }
        }

        return $hd; 
    }

    public function getGenreslistAttribute() 
    {
        $genres = [];
        foreach($this->genres as $genre){
            array_push($genres, $genre['name']);
        }
        return $genres; 
    }

}
