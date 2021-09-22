<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Repositories\ColaboradorRepository;
use App\Models\Ponto;
use App\Repositories\PontoRepository;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function gerarRelatorio(Request $request){

        // Instancia de colaboradores.
        $colaboradoresRepository = new ColaboradorRepository(new Colaborador);
        $colaboradoresRepository->getRelations(['turno.turnoHorarios', 'turno.turnoSemanas']);
        $colaboradores = $colaboradoresRepository->getResult();

        // Pegar primeiro dia e último do mês.
        $intervaloPontos = $colaboradoresRepository->intervaloPontos($request);
        $first = $intervaloPontos['first'];
        $last = $intervaloPontos['last'];

        $colaboradorRelatorio = array();

        foreach($colaboradores as $colaborador){

            if($colaborador->data_admissao > $last->format('Y-m-d 23:59:59')){
                continue;
            }
            // Pegar pontos do mês do fechamento.
            $pontosRepository = new PontoRepository(new Ponto);
            $pontosRepository->whereBetweenR($colaborador->pontos(), 'created_at', $first->format('Y-m-d 00:00:00'), $last->format('Y-m-d 23:59:59'));
            $pontosRepository->whereR('colaborador_id', '=', $colaborador->id);
            $pontosRepository->orderByR('created_at');
            $pontos = $pontosRepository->getResult();


            if($pontos->isNotEmpty()){

                // Retirar pontos não pertercentes ao dia
                $pontosAntesRepository = new PontoRepository(new Ponto);

                $pontos_first = $pontosAntesRepository->subDayFirst($pontos);

                $pontosAntesRepository->whereR('created_at', 'like', $pontos_first->format('Y-m-d').'%');
                $pontosAntesRepository->orderByR('created_at');
                $pontos_antes = $pontosAntesRepository->getResult();

                $pontos = $pontosAntesRepository->retirarPontos($pontos, $pontos_antes);

                // Pegar pontos percentes ao dia no próximo dia
                $pontosDepoisRepository = new PontoRepository(new Ponto);

                $lastAddDay = $pontosDepoisRepository->addDayLast($pontos);

                $pontosDepoisRepository->whereR('created_at', 'like', $lastAddDay->format('Y-m-d').'%');
                $pontosDepoisRepository->whereR('turno_semana_id', '=', $pontos->last()->turno_semana_id);
                $pontosDepoisRepository->orderByR('created_at');
                $pontos_depois = $pontosDepoisRepository->getResult();

                $pontos = $pontosDepoisRepository->pegarPontos($pontos, $pontos_depois);
            }
            $colaboradorRelatorio[$colaborador->nome] = $pontosRepository->relatorioPontos($pontos, $first, $last, $colaborador);
        }
        return $colaboradorRelatorio;
    }
}
