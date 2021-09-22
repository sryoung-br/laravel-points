@extends('layouts.app')

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Dia</th>
                @foreach ($turnos as $turno)
                    @for ($i = 1; $i <= ($turno->turnoHorarios->count() / $turno->turnoSemanas->count()); $i++)
                        <th >
                            {{ $i }}ª Entrada
                        </th>
                        <th>
                            {{ $i }}ª Saída
                        </th>
                    @endfor
                @endforeach
            </tr>
        </thead>
        @foreach ($turnos as $turno)
        <tbody>
            @foreach ($turno->turnoSemanas as $key => $turnoSemana)
            <tr>
                <th>{{ ++$key }}</th>
                    @foreach ($turnoSemana->turnoHorarios as $turnoHorario )
                        <td>{{ $turnoHorario->entrada }}</td>
                        <td>{{ $turnoHorario->saida }}</td>
                    @endforeach
            </tr>
            @endforeach
        </tbody>
        @endforeach
    </table>
</div>
