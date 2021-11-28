<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model {

    //
    protected $table = 'genre';
    public $timestamp = 'false';
    protected $primaryKey = 'id_genre';
    protected $fillable = ['id_genre', 'lib_genre'];

    public function manga() {
        return $this->hasMany('App\Models\Manga', 'id_genre', 'id_genre');
    }

}
