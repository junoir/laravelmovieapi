<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Serie;
use App\Episode;
use App\Livetv;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // navigation routes for the admin panel

    public function index()
    {
        return view('admin.index');
    }

    public function movies()
    {
        return view('admin.movies');
    }

    public function series()
    {
        return view('admin.series');
    }

    public function livetv()
    {
        return view('admin.livetv');
    }

    public function servers()
    {
        return view('admin.servers');
    }

    public function genres()
    {
        return view('admin.genres');
    }

    public function notifications()
    {
        return view('admin.notifications');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function account()
    {
        return view('admin.account');
    }

    // most viewed metrics

    public function topMovies(){
        $movies = Movie::orderBy('views', 'desc')->limit(10)->get();
        
        return response()->json($movies, 200);
    }

    public function topSeries(){
        $series = Serie::all()->makeHidden(['seasons', 'genres'])->sortByDesc('views');

       if($series->count() > 10){
           $series = $series->take(10);
       }

        return response()->json($series, 200);
    }
    public function topEpisodes(){
        $episodes = Episode::orderBy('views', 'desc')->limit(10)->get();
        
        return response()->json($episodes, 200);
    }
    public function topLivetv(){
        $livetv = Livetv::orderBy('views', 'desc')->limit(10)->get();
        
        return response()->json($livetv, 200);
    }

}
