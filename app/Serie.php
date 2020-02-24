<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $fillable = ['tmdb_id', 'name', 'overview', 'poster_path', 'backdrop_path', 'preview_path', 'vote_average', 'vote_count', 'popularity', 'first_air_date'];

    protected $with = ['genres', 'seasons'];
    protected $appends = ['hd', 'genreslist', 'views'];


    public function genres()
    {
        return $this->hasMany('App\SerieGenre');
    }

    public function seasons()
    {
        return $this->hasMany('App\Season')->orderBy('season_number');
    }

    public function getHdAttribute()
    {
        $hd = 0;

        foreach ($this->seasons as $season) {
            foreach ($season->episodes as $episode) {
                foreach ($episode->videos as $video) {
                    if ($video->hd) {
                        $hd = 1;
                    }
                }
            }
        }

        return $hd;
    }

    public function getViewsAttribute()
    {
        $views = 0;
        $counter = 0;

        foreach ($this->seasons as $season) {
            foreach ($season->episodes as $episode) {
                $views += $episode->views;
                $counter++;
            }
        }

        if($views > 0){
            $views = $views / $counter;
        }

        return round($views);
    }

    public function getGenreslistAttribute()
    {
        $genres = [];
        foreach ($this->genres as $genre) {
            array_push($genres, $genre['name']);
        }
        return $genres;
    }
}
