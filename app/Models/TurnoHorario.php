<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnoHorario extends Model
{
    use HasFactory;

    protected $fillable = ['turno_id','turno_semana_id', 'entrada', 'saida'];

    function turno(){
        return $this->belongsTo(Turno::class);
    }

    function turnoSemana(){
        return $this->belongsTo(TurnoSemana::class);
    }

    function rules(){
        return [
            'turno_id' => 'required|exists:turnos,id',
            'turno_semana_id' => 'required|exists:turno_semanas,id',
            'entrada' => 'required|date_format:H:i',
            'saida' => 'required|date_format:H:i'
        ];
    }
    function feedback(){
        return [
            'required' => 'O campo :attribute é necessário',
            'exists' => 'O campo :attribute precisa ser válido',
            'date_format' => 'O campo :attribute precisa ser uma hora válida'
        ];
    }
}
