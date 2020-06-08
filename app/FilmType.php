<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmType extends Model
{
    protected $table = 'film_type';

    public function getFilmType(){
        $type = Type::find($this->id);
        return $type;
    }
}
