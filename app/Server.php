<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Server extends Model
{
    protected $fillable = ['name'];

    public function movie() {
        return $this->belongsTo('App\Movie');
    }
}
