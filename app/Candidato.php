<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $table = "candidatos";
    protected $primaryKey = "id_candidato";

    protected $fillable = ['nome', 'email', 'idade', 'linkedin'];

    public function tecnologias()
    {
        return $this->belongsToMany('App\Tecnologia', 'tecnologias_candidatos', 'candidato_id', 'tecnologia_id');
    }

    static $rules = [
        'nome' => 'required|max:60',
        'email' => 'required|max:60',
        'idade' => 'required|max:3',
        'linkedin' => 'required|max:60',
        'tecsSelected' => ''
    ];
}
