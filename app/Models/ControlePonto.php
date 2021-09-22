<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlePonto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'horario_padrao', 'aplicar_intervalo', 'habilitar_tolerancia', 'tempo_limite', 'primeira_fase', 'segunda_fase', 'habilitar_banco_horas', 'limite_horas_positiva', 'limite_horas_negativa', 'habilitar_adicional_noturno', 'horario_inicial', 'horario_final'];

    function colaboradores(){
        return $this->hasMany(Colaborador::class);
    }

    function rules(){
        return [
            'nome' => 'required|string|max:255',
            'horario_padrao' => 'required',
            'aplicar_intervalo' => 'required|boolean',
            'habilitar_tolerancia' => 'required|boolean',
            'tempo_limite' => 'numeric',
            'primeira_fase' => 'numeric',
            'segunda_fase' => 'numeric',
            'habilitar_banco_horas' => 'required|boolean',
            'limite_horas_positiva' => 'date_format:H:i',
            'limite_horas_negativa' => 'date_format:H:i',
            'habilitar_adicional_noturno' => 'required|boolean',
            'horario_inicial' => 'date_format:H:i',
            'horario_final' => 'date_format:H:i'
        ];
    }
    function feedback(){
        return [
            'required' => 'O campo :attribute é necessário',
            'string' => 'O campo :attribute deve ser uma string',
            'max' => 'O campo :attribute deve conter no máximo :max caracteres',
            'boolean' => 'O campo :attribute deve ser válido',
            'date_format' => 'O campo :attribute deve ser uma hora válida'
        ];
    }
}
