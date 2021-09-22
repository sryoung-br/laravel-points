<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use App\Repositories\ColaboradorRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class ColaboradorController extends Controller
{
    public function __construct(Colaborador $colaborador){
        $this->colaborador = $colaborador;
    }

    public function index()
    {
        $colaboradorRepository = new ColaboradorRepository($this->colaborador);
        $colaboradorRepository->getRelations(['usuario', 'contato', 'equipe', 'turno', 'controlePonto']);
        return response()->json($colaboradorRepository->getResult(), 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->colaborador->rules(), $this->colaborador->feedback());

        $colaborador = $this->colaborador->create($request->all());
        return response()->json($colaborador, 201);
    }

    public function qrcode(Request $request){
        $colaborador = $this->colaborador->where('qrcode', null)->find($request->id);
        if(!$colaborador){
            return ['erro' => 'Colaborador não encontrado ou já registrado um QRcode.'];
        }
        $colaborador->qrcode = Hash::make($colaborador->id.$colaborador->nome.$colaborador->sobrenome.Carbon::now()->format('Y-m-d'));

        $colaborador->save();

        return response()->json($colaborador->qrcode, 201);
    }

    public function show($id)
    {
        $colaborador = $this->colaborador->find($id);

        return response()->json( ($colaborador === null ? ['erro'=>'Recurso não encontrado'] : $colaborador ), ($colaborador === null ? 404 : 200) );
    }

    public function update(Request $request, $id)
    {
        $colaborador = $this->colaborador->find($id);

        if($colaborador === null){
            return response()->json(['erro'=>'Falha na atualização do recurso'], 401);
        }

        $request->validate($request->method() === 'PATCH' ? $colaborador->rulesDinamic($request->all()) : $colaborador->rules(), $colaborador->feedback());

        $colaborador->update($request->all());
        return response()->json($colaborador, 200);
    }

    public function destroy($id)
    {
        $colaborador = $this->colaborador->find($id);
        if($colaborador === null){
            return response()->json(['erro'=>'Falha na exclusão do recurso'], 401);
        }
        $colaborador->delete();
        return response()->json($colaborador, 200);
    }
}
