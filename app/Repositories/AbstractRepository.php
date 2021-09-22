<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

abstract class AbstractRepository {

    public function __construct(Model $model) {
        $this->model = $model;
    }

    //functions...
    public function getRelations($relations){
        $this->model = $this->model->with($relations);
    }
    public function whereR($col, $operador, $valor){
        $this->model = $this->model->where($col, $operador, $valor);
    }
    public function orderByR($col){
        $this->model = $this->model->orderBy($col);
    }

    public function allResult(){
        return $this->model->all();
    }
    public function getResult(){
        return $this->model->get();
    }
    public function findResult($id){
        return $this->model->find($id);
    }

    public function rulesDinamic($rules, $request){

        foreach($rules as $input => $rule){
            if(array_key_exists($input, $request)){
                $rulesDinamic[$input] = $rule;
            }
        }
        return $rulesDinamic;
    }

    public function retirarPontos($pontos, $pontos_antes){
        if($pontos_antes->isNotEmpty()){
            foreach($pontos as $key => $ponto){
                if($ponto->turno_semana_id == $pontos_antes->last()->turno_semana_id){
                    $pontos->pull($key);
                }
                else{
                   break;
                }
            }
        }
        return $pontos;
    }

    public function pegarPontos($pontos, $pontos_depois){
        if($pontos_depois->isNotEmpty()){
            foreach($pontos_depois as $pontos_depois){
                $pontos->push($pontos_depois);
            }
        }
        return $pontos;
    }

    public function subDayFirst($pontos){
        return $pontos->first()->created_at->copy()->subDay();
    }
    public function addDayLast($pontos){
        return $pontos->last()->created_at->copy()->addDay();
    }

    public function intervaloPontos($request){
        if(!$request->has('start') && !$request->has('end')){
            return [
                'first' => Carbon::now()->startOfMonth()->subMonth(),
                'last' => Carbon::now()->endOfMonth()->subMonth()
            ];
        }
        else{
            return [
                'first' => Carbon::create($request->start),
                'last' => Carbon::create($request->end.' 23:59:59')
            ];
        }
    }

    public function whereBetweenR($objeto, $col, $intervalo1, $intervalo2){
        return $objeto->whereBetween($col, [$intervalo1, $intervalo2]);
    }

    public function relatorioPontos($pontos, $first, $last, $colaborador){
        // Pegar todo período do mês
        $periodo = CarbonPeriod::between($first, $last);

        // Pontos incosistentes
        $pontos_inconsistentes = array();
        $colaboradorRelatorio = array();

        // Rodar periodo e verificar pontos inconsistentes
        foreach($periodo as $dia){
            $addDay = $dia->copy()->addDay();

            $pontos_dia = $pontos->whereBetween('created_at', [$dia->format('Y-m-d'), $addDay->format('Y-m-d 23:59')])
                            ->where('turno_semana_id', $dia->dayOfWeekIso)->where('colaborador_id', $colaborador->id);

            $semana = $colaborador->turno->turnoSemanas->where('dia', $dia->dayOfWeekIso)->first();
            $pontos_a_bater = $colaborador->turno->turnoHorarios->where('turno_semana_id', $dia->dayOfWeekIso)->count() * 2;

            if($semana->folga === 0){
                if($pontos_dia->count() < $pontos_a_bater){
                    $pontos_inconsistentes[$dia->format('d-m-Y')] = ['pontos_a_bater' => $pontos_a_bater, 'pontos' => $pontos_dia];
                }
            }
        }
        return $pontos_inconsistentes;
    }
}
