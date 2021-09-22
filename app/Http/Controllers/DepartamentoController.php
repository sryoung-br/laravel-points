<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function __construct(Departamento $departamento){
        $this->departamento = $departamento;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamento = $this->departamento->all();
        if(!$departamento){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($departamento, 200);
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
        $request->validate($this->departamento->rules(), $this->departamento->feedback());

        $departamento = $this->departamento->create($request->all());
        if(!$departamento){
            return response()->json(['erro' => 'Não foi possível criar o recurso'], 401);
        } else{
            return response()->json($departamento, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $departamento = $this->departamento->find($id);
        if(!$departamento){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($departamento, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $departamento = $this->departamento->find($id);

        if($departamento === null){
            return response()->json(['erro'=>'Não foi possível realizar a consulta'], 401);
        }

        $request->validate($request->method() === 'PATCH' ? $departamento->rulesDinamic($request->all()) : $departamento->rules(), $departamento->feedback());

        $departamento->update($request->all());

        return response()->json($departamento, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departamento = $this->departamento->find($id);
        if(!$departamento){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $departamento->delete();
            return response()->json($departamento, 200);
        }
    }
}
