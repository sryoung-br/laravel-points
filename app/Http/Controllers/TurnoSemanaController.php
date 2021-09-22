<?php

namespace App\Http\Controllers;

use App\Models\TurnoSemana;
use Illuminate\Http\Request;
use App\Repositories\TurnoSemanaRepository;

class TurnoSemanaController extends Controller
{
    public function __construct(TurnoSemana $turnoSemana){
        $this->turnoSemana = $turnoSemana;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turnoSemanaRepository = new TurnoSemanaRepository($this->turnoSemana);
        $turnoSemana = $turnoSemanaRepository->allResult();

        if(!$turnoSemana){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($turnoSemana, 200);
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
        $request->validate($this->turnoSemana->rules(), $this->turnoSemana->feedback());

        $turnoSemana = $this->turnoSemana->create($request->all());
        if(!$turnoSemana){
            return response()->json(['erro' => 'Não foi possível criar o recurso'], 401);
        } else{
            return response()->json($turnoSemana, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TurnoSemana  $turnoSemana
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $turnoSemanaRepository = new TurnoSemanaRepository($this->turnoSemana);
        $turnoSemana = $turnoSemanaRepository->findResult($id);

        if(!$turnoSemana){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($turnoSemana, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TurnoSemana  $turnoSemana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $turnoSemanaRepository = new TurnoSemanaRepository($this->turnoSemana);
        $turnoSemana = $turnoSemanaRepository->findResult($id);

        if($turnoSemana === null){
            return response()->json(['erro'=>'Não foi possível realizar a consulta'], 401);
        }
        $request->validate($request->method() === 'PATCH' ? $turnoSemanaRepository->rulesDinamic($turnoSemana->rules(), $request->all()) : $turnoSemana->rules(), $turnoSemana->feedback());

        $turnoSemana->update($request->all());

        return response()->json($turnoSemana, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TurnoSemana  $turnoSemana
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turnoSemanaRepository = new TurnoSemanaRepository($this->turnoSemana);
        $turnoSemana = $turnoSemanaRepository->findResult($id);

        if(!$turnoSemana){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $turnoSemana->delete();
            return response()->json($turnoSemana, 200);
        }
    }
}
