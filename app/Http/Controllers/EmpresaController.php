<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function __construct(Empresa $empresa){
        $this->empresa = $empresa;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa = $this->empresa->all();
        if(!$empresa){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($empresa, 200);
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
        $request->validate($this->empresa->rules(), $this->empresa->feedback());

        $empresa = $this->empresa->create($request->all());
        if(!$empresa){
            return response()->json(['erro' => 'Não foi possível criar o recurso'], 401);
        } else{
            return response()->json($empresa, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = $this->empresa->find($id);
        if(!$empresa){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($empresa, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $empresa = $this->empresa->find($id);

        if($empresa === null){
            return response()->json(['erro'=>'Não foi possível realizar a consulta'], 401);
        }
        $request->validate($request->method() === 'PATCH' ? $empresa->rulesDinamic($request->all()) : $empresa->rules(), $empresa->feedback());

        $empresa->update($request->all());

        return response()->json($empresa, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = $this->empresa->find($id);
        if(!$empresa){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $empresa->delete();
            return response()->json($empresa, 200);
        }
    }
}
