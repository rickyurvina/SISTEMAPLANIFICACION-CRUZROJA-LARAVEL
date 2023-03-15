@extends('modules.projectInternal.project')

@section('title', 'Presupuesto')

@section('project-page')
    <h1 class="subheader-title p-2">
        <i class="fal fa-table text-primary"></i> Presupuesto
    </h1>
    <div class="card">
        <table class="p-2 m-4">
            <tr>
                <td colspan="11"></td>
                <td colspan="2" class="border p-2 bold-h4 text-center" style="background-color: #92D050">Directo</td>
            </tr>
            <tr>
                <td colspan="11"></td>
                <td colspan="2" class="border p-2 bold-h4 text-center" style="background-color: #00B0F0">PRY 539</td>
            </tr>
            <tr style="background-color: #FFF2CC" >
                <th class="text-center border p-2 bold-h4">N°</th>
                <th class="text-center border p-2 bold-h4">Código Actividad</th>
                <th class="text-center border p-2 bold-h4" >Código Partida</th>
                <th class="text-center border p-2 bold-h4" >Partida</th>
                <th class="text-center border p-2 bold-h4" >Actividad</th>
                <th class="text-center border p-2 bold-h4" >Cantidad</th>
                <th class="text-center border p-2 bold-h4" >Unidad</th>
                <th class="text-center border p-2 bold-h4" >Valor Unitario</th>
                <th class="text-center border p-2 bold-h4" >Peso Ponderado</th>
                <th class="text-center border p-2 bold-h4" style="background-color: #833C0C; color:#fffffd">Valor Total P.</th>
                <th class="text-center border p-2 bold-h4" style="background-color: #375623; color:#fffffd"> Total Financiado</th>
                <th class="text-center border p-2 bold-h4" style="background-color: #C6E0B4">Nombre proyecto</th>
                <th class="text-center border p-2 bold-h4" style="background-color: #C6E0B4">EF/VE</th>
            </tr>
            <tr style="background-color: #BFBFBF">
                <td class="text-center border p-2" colspan="8">nombre sector (SAPH)</td>
                <td class="text-center border p-2">48%</td>
                <td class="text-center border p-2">$12355</td>
                <td class="text-center border p-2">$5664</td>
                <td class="text-center border p-2">$256892</td>
                <td class="text-center border p-2"></td>
            </tr>
            <tr style="background-color: #D9E1F2">
                <td class="text-center border p-2" colspan="8">nombre del sector del resultado(SAPH 1)</td>
                <td class="text-center border p-2">22.05%</td>
                <td class="text-center border p-2">$12521</td>
                <td class="text-center border p-2">$96766</td>
                <td class="text-center border p-2">$256892</td>
                <td class="text-center border p-2"></td>
            <tr>
                <td class="text-center border p-2">1</td>
                <td class="text-center border p-2">SAPH1.1</td>
                <td class="text-center border p-2">PAC 01 001 001</td>
                <td class="text-center border p-2">Nombre partida</td>
                <td class="text-center border p-2">texto actividad</td>
                <td class="text-center border p-2">24</td>
                <td class="text-center border p-2">vehiculos</td>
                <td class="text-center border p-2">$25.00</td>
                <td class="text-center border p-2">---</td>
                <td class="text-center border p-2">cantidad * valor unitario</td>
                <td class="text-center border p-2">$256892</td>
                <td class="text-center border p-2"></td>
                <td class="text-center border p-2">e</td>
            </tr>
            <tr>
                <td class="text-center border p-2">2</td>
                <td class="text-center border p-2">SAPH1.2</td>
                <td class="text-center border p-2">PAC 01 001 002</td>
                <td class="text-center border p-2">Nombre partida</td>
                <td class="text-center border p-2">texto actividad</td>
                <td class="text-center border p-2">24</td>
                <td class="text-center border p-2">vehiculos</td>
                <td class="text-center border p-2">$25.00</td>
                <td class="text-center border p-2">---</td>
                <td class="text-center border p-2">cantidad * valor unitario</td>
                <td class="text-center border p-2">$256892</td>
                <td class="text-center border p-2"></td>
                <td class="text-center border p-2"></td>
            </tr>
            <tr>
                <td colspan="9" style="background-color: #9BC2E6" class="text-center border p-2 bold-h4">TOTAL GENERAL</td>
                <td class="text-center border p-2" style="background-color: #833C0C; color:#fffffd">$123456</td>
                <td class="text-center border p-2" style="background-color: #375623; color:#fffffd">$12586</td>
                <td class="text-center border p-2">$1235</td>
                <td class="text-center border p-2">$4854</td>
            </tr>
        </table>
        <table class="m-4">
            <tr class="text-center bold-h4"> FONDOS NO CONDICIONADOS (Fondo de BP Emergencia (FnC)</tr>
            <tr>
                <th class="border p-2 text-center bold-h4">Aportantes FnC</th>
                <th class="border p-2 text-center bold-h4">Recibido</th>
            </tr>
            <tr>
                <td class="border p-2 text-center">Asambleistas</td>
                <td class="border p-2 text-center">$40000.00</td>
            </tr>
            <tr>
                <td class="border p-2 text-center">Nokia</td>
                <td class="border p-2 text-center">$40000.00</td>
            </tr>
            <tr>
            <td class="border p-2 text-center bold-h4">Total</td>
            <td class="border p-2 text-center">$8000.00</td>
            </tr>
        </table>
    </div>

@endsection

