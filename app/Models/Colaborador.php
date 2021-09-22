<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = 'colaboradores';

    protected $fillable = ['nome', 'sobrenome', 'cpf', 'pis', 'centro_custo', 'matricula',
    'data_admissao', 'cargo', 'equipe_id', 'turno_id', 'controle_ponto_id', 'registra_ponto', 'clt', 'contato_id'];

   function usuario(){
        return $this->hasOne(User::class);
   }

   function contato(){
        return $this->belongsTo(Contato::class);
   }

    function equipe(){
        return $this->belongsTo(Equipe::class);
    }

    function turno(){
        return $this->belongsTo(Turno::class);
    }

    function controlePonto(){
        return $this->belongsTo(ControlePonto::class);
    }

    function pontos(){
        return $this->hasMany(Ponto::class);
    }

    function rules(){
        return [
            'nome' => 'required',
            'sobrenome' => 'required',
            'cpf' => 'required|unique:colaboradores,cpf,'.$this->id.'|min:11',
            'pis' => 'required|unique:colaboradores,pis,'.$this->id.'',
            'matricula' => 'required|unique:colaboradores,matricula,'.$this->id.'',
            'centro_custo' => 'required|unique:colaboradores,centro_custo,'.$this->id.'',
            'data_admissao' => 'date',
            'cargo' => 'required',
            'equipe_id' => 'required|exists:equipes,id',
            'turno_id' => 'exists:turnos,id',
            'controle_ponto_id' => 'exists:controle_pontos,id',
            'registra_ponto' => 'required|boolean',
            'clt' => 'required|boolean',
            'contato_id' => 'exists:contatos,id'

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
            'required' => 'O campo :attribute é necessário.',
            'cpf.min' => 'O CPF precisa ser valido.'
        ];
    }
}
