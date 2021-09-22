<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function __construct(Contato $contato){
        $this->contato = $contato;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contato = $this->contato->all();
        if(!$contato){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($contato, 200);
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
        $request->validate($this->contato->rules(), $this->contato->feedback());

        $contato = $this->contato->create($request->all());
        if(!$contato){
            return response()->json(['erro' => 'Não foi possível criar o recurso'], 401);
        } else{
            return response()->json($contato, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contato = $this->contato->find($id);
        if(!$contato){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($contato, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contato = $this->contato->find($id);

        if($contato === null){
            return response()->json(['erro'=>'Não foi possível realizar a consulta'], 401);
        }

        $request->validate($request->method() === 'PATCH' ? $contato->rulesDinamic($request->all()) : $contato->rules(), $contato->feedback());

        $contato->update($request->all());

        return response()->json($contato, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contato = $this->contato->find($id);
        if(!$contato){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $contato->delete();
            return response()->json($contato, 200);
        }
    }
}
