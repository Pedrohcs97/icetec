<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tecnologia extends Model
{
    protected $primaryKey = "id_tecnologia";
    protected $table = "tecnologias";

    protected $fillable = ['nome'];

    public function candidatos()
    {
        return $this->belongsToMany('App\Candidato', 'tecnologias_candidatos', 'tecnologia_id', 'candidato_id');
    }
}
