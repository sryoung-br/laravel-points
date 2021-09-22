<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    protected $fillable = ['telefone', 'celular', 'cep', 'tipo_local', 'endereco', 'numero', 'complemento', 'bairro', 'cidade'];

    function empresa() {
        return $this->hasOne(Empresa::class);
    }

    function colaborador() {
        return $this->hasOne(Colaborador::class);
    }

    function rules(){
        return [
            'telefone' => 'required|numeric|digits_between:5,20',
            'celular' => 'numeric|digits_between:5,20|nullable',
            'cep' => 'required|numeric|digits_between:5,20',
            'tipo_local' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'complemento' => 'string|nullable',
            'bairro' => 'required',
            'cidade' => 'required'
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
            'required' => 'O campo :attribute é necessário',
            'numeric' => 'O campo :attribute deve contem somente números',
            'digits_between' => 'O campo :attribute deve ser maior que :min e menor que :max'
        ];
    }
}
