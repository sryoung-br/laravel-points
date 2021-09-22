<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Http\Request;
use App\Repositories\TurnoRepository;

class TurnoController extends Controller
{
    public function __construct(Turno $turno){
        $this->turno = $turno;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turnoRepository = new TurnoRepository($this->turno);
        $turno = $turnoRepository->allResult();

        if(!$turno){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($turno, 200);
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
        $request->validate($this->turno->rules(), $this->turno->feedback());

        $turno = $this->turno->create($request->all());
        if(!$turno){
            return response()->json(['erro' => 'Não foi possível criar o recurso'], 401);
        } else{
            return response()->json($turno, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $turnoRepository = new TurnoRepository($this->turno);
        $turno = $turnoRepository->findResult($id);

        if(!$turno){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($turno, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $turnoRepository = new TurnoRepository($this->turno);
        $turno = $turnoRepository->findResult($id);

        if($turno === null){
            return response()->json(['erro'=>'Não foi possível realizar a consulta'], 401);
        }
        $request->validate($request->method() === 'PATCH' ? $turnoRepository->rulesDinamic($turno->rules(), $request->all()) : $turno->rules(), $turno->feedback());

        $turno->update($request->all());

        return response()->json($turno, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turnoRepository = new TurnoRepository($this->turno);
        $turno = $turnoRepository->findResult($id);

        if(!$turno){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $turno->delete();
            return response()->json($turno, 200);
        }
    }
}
