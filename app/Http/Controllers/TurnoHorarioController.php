<?php

namespace App\Http\Controllers;

use App\Models\TurnoHorario;
use Illuminate\Http\Request;
use App\Repositories\TurnoHorarioRepository;

class TurnoHorarioController extends Controller
{
    public function __construct(TurnoHorario $turnoHorario){
        $this->turnoHorario = $turnoHorario;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turnoHorarioRepository = new TurnoHorarioRepository($this->turnoHorario);
        $turnoHorario = $turnoHorarioRepository->allResult();

        if(!$turnoHorario){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($turnoHorario, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->turnoHorario->rules(), $this->turnoHorario->feedback());

        $turnoHorario = $this->turnoHorario->create($request->all());
        if(!$turnoHorario){
            return response()->json(['erro' => 'Não foi possível criar o recurso'], 401);
        } else{
            return response()->json($turnoHorario, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TurnoHorario  $turnoHorario
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $turnoHorarioRepository = new TurnoHorarioRepository($this->turnoHorario);
        $turnoHorario = $turnoHorarioRepository->findResult($id);

        if(!$turnoHorario){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($turnoHorario, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TurnoHorario  $turnoHorario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $turnoHorarioRepository = new TurnoHorarioRepository($this->turnoHorario);
        $turnoHorario = $turnoHorarioRepository->findResult($id);

        if($turnoHorario === null){
            return response()->json(['erro'=>'Não foi possível realizar a consulta'], 401);
        }
        $request->validate($request->method() === 'PATCH' ? $turnoHorarioRepository->rulesDinamic($turnoHorario->rules(), $request->all()) : $turnoHorario->rules(), $turnoHorario->feedback());

        $turnoHorario->update($request->all());

        return response()->json($turnoHorario, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TurnoHorario  $turnoHorario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turnoHorarioRepository = new TurnoHorarioRepository($this->turnoHorario);
        $turnoHorario = $turnoHorarioRepository->findResult($id);

        if(!$turnoHorario){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $turnoHorario->delete();
            return response()->json($turnoHorario, 200);
        }
    }
}
