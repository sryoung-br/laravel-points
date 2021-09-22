<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Repositories\EquipeRepository;

class EquipeController extends Controller
{
    public function __construct(Equipe $equipe){
        $this->equipe = $equipe;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipeRepository = new EquipeRepository($this->equipe);
        $equipe = $equipeRepository->allResult();

        if(!$equipe){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($equipe, 200);
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
        $request->validate($this->equipe->rules(), $this->equipe->feedback());

        $equipe = $this->equipe->create($request->all());
        if(!$equipe){
            return response()->json(['erro' => 'Não foi possível criar o recurso'], 401);
        } else{
            return response()->json($equipe, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipe  $equipe
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $equipeRepository = new EquipeRepository($this->equipe);
        $equipe = $equipeRepository->findResult($id);

        if(!$equipe){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            return response()->json($equipe, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipe  $equipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $equipeRepository = new EquipeRepository($this->equipe);
        $equipe = $equipeRepository->findResult($id);

        if($equipe === null){
            return response()->json(['erro'=>'Não foi possível realizar a consulta'], 401);
        }
        $request->validate($request->method() === 'PATCH' ? $equipeRepository->rulesDinamic($equipe->rules(), $request->all()) : $equipe->rules(), $equipe->feedback());

        $equipe->update($request->all());

        return response()->json($equipe, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipe  $equipe
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equipeRepository = new EquipeRepository($this->equipe);
        $equipe = $equipeRepository->findResult($id);

        if(!$equipe){
            return response()->json(['erro' => 'Não foi possível realizar a consulta'], 401);
        }
        else{
            $equipe->delete();
            return response()->json($equipe, 200);
        }
    }
}
