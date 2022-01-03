<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Exception;

class Commentaire extends Model
{
    protected $table = 'commentaire';
    public $timestamps = false;
    protected $primaryKey = 'id_commentaire';
    protected $fillable = ['id_commentaire', 'id_lecteur', 'id_manga', 'lib_commentaire'];

    public function manga()
    {
        return $this->belongsTo('App\Models\Manga', 'id_manga', 'id_manga');
    }

    public function lecteur()
    {
        return $this->belongsTo('App\Models\Lecteur', 'id_lecteur', 'id_lecteur');
    }
}
