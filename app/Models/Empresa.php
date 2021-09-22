<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['cnpj', 'nome', 'razao_social', 'inscricao_estadual', 'empregadora', 'cei_ceno', 'logotipo', 'notas_observacoes', 'contato_id'];

    function contato() {
        return $this->belongsTo(Contato::class);
    }

    function departamentos() {
        return $this->hasMany(Departamento::class);
    }

    function rules(){
        return [
            'cnpj' => 'required|numeric|digits:14|unique:empresas,cnpj,'.$this->id,
            'nome' => 'nullable|string|max:100',
            'razao_social' => 'required|string|max:100',
            'inscricao_estadual' => 'nullable|max:100',
            'empregadora' => 'boolean',
            'cei_ceno' => 'nullable|string',
            'logotipo' => 'nullable|file|mimes:jpg,png|max:2000',
            'notas_observacoes' => 'string|max:255|nullable',
            'contato_id' => 'nullable|exists:contatos,id'
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
            'logotipo.max' => 'O campo :attribute precisa ter no máximo :max kbytes',
            'file' => 'O campo :attribute precisa ser um arquivo',
            'mimes' => 'O campo :attribute precisa ser jpg ou png',
            'boolean' => 'O campo :attribute precisa ser válido',
            'numeric' => 'O campo :attribute precisa ser numérico',
            'cnpj.digits' => 'O campo CNPJ precisa ter 14 caracteres',
            'exists' => 'O campo :attribute precisa ser válido',
            'required' => 'O campo :attribute é necessário',
            'max' => 'O campo :attribute deve conter no máximo :max caracteres',
            'string' => 'O campo :attribute deve ser string'
        ];
    }
}
