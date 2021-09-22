<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ColaboradorController, ControlePontoController, ContatoController, DepartamentoController, EmpresaController, EquipeController, TurnoController, TurnoHorarioController, TurnoSemanaController, PontoController, RelatorioController};

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api')->prefix('v1')->group(function () {

    Route::post('/relatorio', [RelatorioController::class, 'gerarRelatorio']);

    Route::apiResource('/colaborador', ColaboradorController::class);

    Route::post('/colaborador/qrcode', [ColaboradorController::class, 'qrcode']);

    Route::apiResource('/controle-ponto', ControlePontoController::class);

    Route::apiResource('/contato', ContatoController::class);

    Route::apiResource('/departamento', DepartamentoController::class);

    Route::apiResource('/empresa', EmpresaController::class);

    Route::apiResource('/equipe', EquipeController::class);

    Route::apiResource('/turno', TurnoController::class);

    Route::apiResource('/turno-horario', TurnoHorarioController::class);

    Route::apiResource('/turno-semana', TurnoSemanaController::class);

    Route::post('/ponto/{id}', [PontoController::class, 'index']);

    Route::apiResource('/ponto', PontoController::class);
});


