<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnoSemana extends Model
{
    use HasFactory;

    protected $fillable = ['dia', 'turno_id', 'virada_turno', 'limite_horas_extra', 'folga'];

    function turno(){
        return $this->belongsTo(Turno::class);
    }

    function turnoHorarios(){
        return $this->hasMany(TurnoHorario::class);
    }

    function rules(){
        return [
            'dia' => 'required|between:1,7',
            'turno_id' => 'required|exists:turnos,id',
            'virada_turno' => 'required|date_format:H:i:s',
            'limite_horas_extra' => 'required|date_format:H:i',
            'folga' => 'required|boolean'
        ];
    }
    function feedback(){
        return [
            'required' => 'O campo :attribute é necessário',
            'exists' => 'O campo :attribute precisa ser válido',
            'date_format' => 'O campo :attribute precisa ser uma hora válida',
            'boolean' => 'O campo :attribute precisa ser válido'
        ];
    }
}
