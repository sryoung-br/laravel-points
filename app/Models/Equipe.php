<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'departamento_id', 'gestor_id', 'notas_observacoes'];

    function departamento(){
        return $this->belongsTo(Departamento::class);
    }

    function gestor(){
        return $this->belongsTo(User::class);
    }

    function colaboradores(){
        return $this->hasMany(Colaborador::class);
    }

    function rules(){
        return [
            'nome' => 'required|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
            'gestor_id' => 'exists:colaboradores,id'
        ];
    }

    function feedback(){
        return [
            'required' => 'O campo :attribute é necessário',
            'exists' => 'O campo :attribute deve ser válido'
        ];
    }
}
