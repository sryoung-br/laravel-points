<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'empresa_id', 'notas_observacoes'];

    function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    function equipes(){
        return $this->hasMany(Equipe::class);
    }

    function rules(){
        return [
            'nome' => 'required|string|max:100',
            'empresa_id' => 'required|exists:empresas,id',
            'notas_observacoes' => 'string|max:255|nullable'
        ];
    }
    function rulesDinamic($request){

        foreach($this->rules() as $input => $rule){
            if(array_key_exists($input, $request)){
                $rulesDinamic[$input] = $rule;
            }
        }
        return $rulesDinamic;
    }
    function feedback(){
        return [
            'exists' => 'O campo :attribute precisa ser válido',
            'required' => 'O campo :attribute é necessário',
            'max' => 'O campo :attribute deve conter no máximo :max caracteres',
            'string' => 'O campo :attribute deve ser string'
        ];
    }
}
