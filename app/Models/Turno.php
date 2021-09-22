<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = ['descricao'];

    function colaboradores(){
        return $this->hasMany(Colaborador::class);
    }

    function turnoSemanas(){
        return $this->hasMany(TurnoSemana::class);
    }

    function turnoHorarios(){
        return $this->hasMany(TurnoHorario::class);
    }

    function rules(){
        return [
            'descricao' => 'required|string|max:255',
        ];
    }

    function feedback(){
        return [
            'descricao.required' => 'O campo descrição é necessário',
            'descricao.string' => 'O campo descrição precisa ser uma string',
            'descricao.max' => 'O campo descrição deve conter no máximo 255 caracteres'
        ];
    }
}
