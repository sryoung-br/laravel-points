<?php

namespace App\Http\Controllers;

use App\Models\Ponto;
use App\Repositories\PontoRepository;
use App\Models\Colaborador;
use Illuminate\Http\Request;

class PontoController extends Controller
{
    public function __construct(Ponto $ponto){
        $this->ponto = $ponto;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $pontosRepository = new PontoRepository($this->ponto);
        $pontosRepository->whereR('created_at', 'like', $request->date.'%');
        $pontosRepository->whereR('colaborador_id', '=', $id);
        $pontosRepository->orderByR('created_at');
        $pontos = $pontosRepository->getResult();

        // Retirar pontos não pertercentes ao dia
        if($pontos->isNotEmpty()){
            $pontosAntesRepository = new PontoRepository($this->ponto);

            $pontos_first = $pontosAntesRepository->subDayFirst($pontos);

            $pontosAntesRepository->whereR('created_at', 'like', $pontos_first->format('Y-m-d').'%');
            $pontosAntesRepository->orderByR('created_at');
            $pontos_antes = $pontosAntesRepository->getResult();

            $pontos = $pontosRepository->retirarPontos($pontos, $pontos_antes);
        }

        // Pegar pontos percentes ao dia no próximo dia
        if($pontos->isNotEmpty()){
            $pontosDepoisRepository = new PontoRepository($this->ponto);

            $lastAddDay = $pontosDepoisRepository->addDayLast($pontos);

            $pontosDepoisRepository->whereR('created_at', 'like', $lastAddDay->format('Y-m-d').'%');
            $pontosDepoisRepository->whereR('turno_semana_id', '=', $pontos->last()->turno_semana_id);
            $pontosDepoisRepository->orderByR('created_at');
            $pontos_depois = $pontosDepoisRepository->getResult();

            $pontos = $pontosRepository->pegarPontos($pontos, $pontos_depois);
        }

        if($pontos->isEmpty()){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }

        return response()->json($pontos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->ponto->rules(), $this->ponto->feedback());

        // Pega colaborador.
        $colaborador = $this->ponto->colaboradorPonto($request->qrcode);

        if($colaborador['erro']){
            return response()->json(['erro' => $colaborador['erro']], $colaborador['resposta']);
        }

        // Pega o dia de ontem;
        $ontem = $this->ponto->pegaDia($colaborador, 'ontem');

        // Pega pontos do dia atual;
        $pontos_hoje = $this->ponto->pegaPontos($colaborador->id, null);

        // Verifica o turno de ontem
        $turno_ontem = $this->ponto->verificaTurno($ontem);

        if($turno_ontem){

            $pontos_ontem = $this->ponto->pegaPontos($colaborador->id, $ontem->id);

            $horarios_ontem = $this->ponto->pegaHorarios($colaborador, $ontem->id);

            $ponto = $this->ponto->batePonto($pontos_ontem->count(), $pontos_dia_atual->count(), $horarios_ontem->count(), $colaborador->id, $ontem->id);

            if($ponto){
                return response()->json($ponto, 200);
            }
            else{
                return response()->json(["erro" => "Sua próxima jornada poderá começar somente após as {$ontem->virada_turno}"], 202);
            }
        }
        else{
            $hoje = $this->ponto->pegaDia($colaborador, 'hoje');
            // Verifica se tem expediente hoje
            if($hoje->folga === 1){
                return response()->json(['erro'=>'Você está de folga, portanto não poderá bater pontos hoje.'], 202);
            }
            else
            {
                $horarios_hoje = $this->ponto->pegaHorarios($colaborador, $hoje->id);

                $ponto = $this->ponto->batePonto(0, $pontos_hoje->where('turno_semana_id', $hoje->id)->count(), $horarios_hoje->count(), $colaborador->id, $hoje->id);

                if($ponto){
                    return response()->json($ponto, 200);
                }
                else{
                    return response()->json(["erro" => "Sua próxima jornada poderá começar somente após as {$hoje->virada_turno}"], 202);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ponto  $ponto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ponto = $this->ponto->find($id);
        if($ponto->isEmpty()){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        return response()->json($ponto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ponto  $ponto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ponto = $this->ponto->find($id);
        if(!$ponto){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $ponto->update($request->all());
        }
        return response()->json($ponto, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ponto  $ponto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ponto = $this->ponto->find($id);
        if(!$ponto){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $ponto->delete();
        }
        return response()->json($ponto, 200);
    }
}
