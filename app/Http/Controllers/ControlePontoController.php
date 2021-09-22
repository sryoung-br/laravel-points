<?php

namespace App\Http\Controllers;

use App\Models\ControlePonto;
use App\Repositories\ControlePontoRepository;
use App\Models\Colaborador;
use App\Repositories\ColaboradorRepository;
use Illuminate\Http\Request;


class ControlePontoController extends Controller
{
    public function __construct(ControlePonto $controlePonto){
        $this->controlePonto = $controlePonto;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controlePontoRepository = new ControlePontoRepository($this->controlePonto);
        $controlePonto = $controlePontoRepository->allResult();

        if(!$controlePonto){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($controlePonto, 200);
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
        $request->validate($this->controlePonto->rules(), $this->controlePonto->feedback());

        $controlePonto = $this->controlePonto->create($request->all());
        if(!$controlePonto){
            return response()->json(['erro' => 'Não foi possível criar o recurso'], 401);
        } else{
            return response()->json($controlePonto, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ControlePonto  $controlePonto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $controlePontoRepository = new ControlePontoRepository($this->controlePonto);
        $controlePonto = $controlePontoRepository->findResult($id);

        if(!$controlePonto){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($controlePonto, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ControlePonto  $controlePonto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $controlePontoRepository = new ControlePontoRepository($this->controlePonto);
        $controlePonto = $controlePontoRepository->findResult($id);

        if($controlePonto === null){
            return response()->json(['erro'=>'Não foi possível realizar a consulta'], 401);
        }
        $request->validate($request->method() === 'PATCH' ? $controlePontoRepository->rulesDinamic($controlePonto->rules(), $request->all()) : $controlePonto->rules(), $controlePonto->feedback());

        $controlePonto->update($request->all());

        return response()->json($controlePonto, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ControlePonto  $controlePonto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $controlePontoRepository = new ControlePontoRepository($this->controlePonto);
        $controlePonto = $controlePontoRepository->findResult($id);

        if(!$controlePonto){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $controlePonto->delete();
            return response()->json($controlePonto, 200);
        }
    }
}
