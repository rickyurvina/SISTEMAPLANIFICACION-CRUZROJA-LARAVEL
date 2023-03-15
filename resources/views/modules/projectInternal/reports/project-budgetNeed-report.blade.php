@extends('modules.projectInternal.project')

@section('title', 'Necesidad Presupuestaria')


@section('project-page')
    <h1 class="subheader-title p-2">
        <i class="fal fa-table text-primary"></i> Necesidad Presupuestaria
    </h1>
    <div class="card">
        <table class="p-2 m-4">
            <tr>
                <th class="text-center border p-2 bold-h4" colspan="5" style="background-color: #305496;color:#fffffd">NECESIDAD PRESUPUESTARIA</th>
            </tr>
            <tr>
                <th class="text-center border p-2 bold-h4" >Partidas</th>
                <th class="text-center border p-2 bold-h4" >Suma Requerida</th>
                <th class="text-center border p-2 bold-h4" >Suma Financiada</th>
                <th class="text-center border p-2 bold-h4" >Fondo Bayer</th>
                <th class="text-center border p-2 bold-h4" >Cr Espanola</th>
            </tr>
        <tr>
            <td class="text-center border p-2">Gastos Administrativos</td>
            <td class="text-center border p-2">$123456</td>
            <td class="text-center border p-2">$12586</td>
            <td class="text-center border p-2">$6895</td>
            <td class="text-center border p-2">$4582</td>
        </tr>
            <tr>
                <td class="text-center border p-2 bold-h4">TOTAL GENERAL</td>
                <td class="text-center border p-2">$123456</td>
                <td class="text-center border p-2">$12586</td>
                <td class="text-center border p-2">$6895</td>
                <td class="text-center border p-2">$4582</td>
            </tr>
        </table>
    </div>

@endsection

