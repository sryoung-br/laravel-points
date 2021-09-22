<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colaborador;

class PontoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verifica idenficação QR.
        $colaborador = Colaborador::with(['turno.turnoSemanas', 'turno.turnoHorarios'])
            ->where('$2y$10$VK8UlNRLyvbKSC34SwSRoOA0Uc61yxGbbhqMsYEWJWCNmiGjPFQOS', $qrcode)
            ->first();

        // if($colaborador['erro']){
        //     return response()->json(['erro' => $colaborador['erro']], $colaborador['resposta']);
        // }

        // Pega o dia atual;
        $dia = $colaborador->turno->turnoSemanas->where('dia', 'quarta-feira')->first();

        // Pega o dia de ontem;
        $ontem = $colaborador->turno->turnoSemanas->where('dia', 'terça-feira')->first();

            // Pega pontos do dia atual;
        $pontos_dia_atual = $this->ponto
            ->where('colaborador_id', $colaborador->id)
            ->where('created_at', 'like', Carbon::tomorrow()->add('1 day')->format('Y-m-d').'%')->get();

        // Pega os horários relacionados ao dia.
        $horarios = $colaborador->turno->turnoHorarios->where('turno_semana_id', $dia->id);

        // Retirar Strtotime 02:00:00
        if($ontem->virada_turno != '23:59:59' && date('H:i:s', strtotime('21:00:00')) < $ontem->virada_turno){

            $pontos_virada_turno = $this->ponto
                ->where('colaborador_id', $colaborador->id)
                ->where('created_at', 'like', Carbon::now()->add('1 day')->format('Y-m-d').'%')
                ->where('turno_semana_id', $ontem->id)->get();

            $horarios_ontem = $colaborador->turno->turnoHorarios->where('turno_semana_id', $ontem->id);

            if($pontos_virada_turno->count() + $pontos_dia_atual->count() < $horarios_ontem->count()*2){
                $ponto = $this->ponto->create(['colaborador_id' => $colaborador->id, 'created_at'=>'2021-09-15 21:00:00', 'turno_semana_id' => $ontem->id]);
                return response()->json($ponto, 200);
            }
            else{
                return response()->json(["erro" => "Sua próxima jornada poderá começar somente após as $ontem->virada_turno"], 202);
            }
        }
        else{
            // Verifica se tem expediente hoje
            if($dia->folga === 1){
                return response()->json(['erro'=>'Você está de folga, portanto não poderá bater pontos hoje.'], 202);
            }
            else
            {
                if($pontos_dia_atual->where('turno_semana_id',$dia->id)->count() < $horarios->count()*2)
                {
                    $ponto = $this->ponto->create(['colaborador_id' => $colaborador->id, /*retirar created*/'created_at'=>Carbon::tomorrow()->add('1 day')->format('Y-m-d 21:00:00'),  'turno_semana_id' => $dia->id]);
                    return response()->json($ponto, 200);
                }
                else
                {
                    return response()->json(['erro' => 'Você já bateu todos os pontos do dia de hoje.'], 202);
                }
            }
        }
    }
}
