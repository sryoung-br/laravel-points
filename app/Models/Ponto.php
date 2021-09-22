<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ponto extends Model
{
    use HasFactory;

    protected $fillable = ['colaborador_id', 'created_at', 'turno_semana_id'];

    function colaborador(){
        return $this->belongsTo(Colaborador::class);
    }

    function rules(){
        return [
            'qrcode' => 'required|exists:colaboradores,qrcode',
        ];
    }
    function feedback(){
        return [
            'required' => 'O campo :attribute é necessário.',
            'exists' => 'Não foi encontrado esse colaborador.'
        ];
    }

    function colaboradorPonto($qrcode){
        $colaborador = Colaborador::with(['turno.turnoSemanas', 'turno.turnoHorarios'])
            ->where('qrcode', $qrcode)
            ->first();

        // Verificar se o colaborador pertence a algum turno.
        if($colaborador->turno_id === null){
            return ['erro'=>'Você não pertence a nenhum turno, portanto não poderá bater pontos.', 'resposta' => 202];
        }
        elseif($colaborador->registra_ponto === 0){
            return ['erro'=>'Você não está autorizado a bater pontos', 'resposta' => 202];
        }
        else{
            return $colaborador;
        }
    }

    function pegaDia($colaborador, $dia){
        return $colaborador->turno->turnoSemanas
            ->where('dia', ( $dia == 'hoje' ?  Carbon::now()->dayOfWeekIso : Carbon::yesterday()->dayOfWeekIso ))
            ->first();
    }

    function pegaPontos($colaborador_id, $ontem_id){
        $pontos = $this->where('colaborador_id', $colaborador_id)
                    ->where('created_at', 'like', ($ontem_id ? Carbon::yesterday()->format('Y-m-d') : Carbon::now()->format('Y-m-d')).'%' );
        if($ontem_id){
            $pontos = $pontos->where('turno_semana_id', $ontem_id);
        }
        return $pontos->get();
    }

    function verificaTurno($ontem){
        if($ontem->folga === 0 && $ontem->virada_turno != '23:59:59' && Carbon::now()->format('H:i:s') < $ontem->virada_turno){
            return true;
        }
    }

    function pegaHorarios($colaborador, $dia_id){
        return $colaborador->turno->turnoHorarios->where('turno_semana_id', $dia_id);
    }

    function batePonto($pontos_ontem, $pontos_hoje, $horarios, $colaborador_id, $dia_id){
        if( ($pontos_ontem + $pontos_hoje) < $horarios * 2){
            return $this->create(['colaborador_id' => $colaborador_id, 'turno_semana_id' => $dia_id]);
        }
    }
}
