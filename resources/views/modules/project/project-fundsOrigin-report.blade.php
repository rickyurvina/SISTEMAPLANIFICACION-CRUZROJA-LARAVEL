@extends('modules.project.project')

@section('title', 'Informe de origen de fondos')


@section('project-page')

    <ol class="breadcrumb bg-transparent pl-2 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('projects.reportsIndex', $project->id) }}">
                Informes del Proyecto
            </a>
        </li>
        <li class="breadcrumb-item active"> INFORME DE ORIGEN DE FONDOS</li>
    </ol>

    <div class="container-fluid">
        <div class="w-100 p-2">
            <x-label-section> INFORME DE ORIGEN DE FONDOS</x-label-section>
        </div>
        <div class="flex-grow-1 w-100" style="overflow: hidden auto">
            <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-incomes1" role="tab" aria-selected="true">Sector</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-incomes2" role="tab" aria-selected="false">Sector y Resultado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-incomes3" role="tab" aria-selected="false">Aportes Recibidos Ingresos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-expenses1" role="tab" aria-selected="false">Sectores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-expenses2" role="tab" aria-selected="false"> Presupuesto Global</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-expenses3" role="tab" aria-selected="false">Presupuesto Financiado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-expenses4" role="tab" aria-selected="false">Aportes Recibidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-expenses5" role="tab" aria-selected="false">Resultados</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="tab-incomes1" role="tabpanel">
                    <div class="p-2">
                        <h4 class="bold-h4 p-2" style="color:#38A1F3">INGRESOS</h4>
                        <h5 class="bold-h4">Presupuesto por Sector</h5>
                        <table class="p-2  w-100">
                            <tr>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color: #FFF2CC">COD</th>
                                <th class="text-center w-30 border p-2 bold-h4" style="background-color: #FFF2CC">Sector</th>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto Global</th>
                                <th class="text-center w-20 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto Financiado</th>
                                <th class="text-center w-20 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto por Financiar</th>
                            </tr>
                            <tr>
                                <td class="text-center border p-2">codigo sector</td>
                                <td class="text-center border p-2">nombre sector</td>
                                <td class="text-center border p-2">$5158</td>
                                <td class="text-center border p-2">$848</td>
                                <td class="text-center border p-2">$56488</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center border p-2">Total</td>
                                <td class="text-center border p-2">total presupuesto global</td>
                                <td class="text-center border p-2">total presupuesto financiado</td>
                                <td class="text-center border p-2">total presupuesto por financiar</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-incomes2" role="tabpanel">
                    <div class="pl-2">
                        <h4 class="bold-h4 p-2" style="color:#38A1F3">INGRESOS</h4>
                        <h5 class="bold-h4 ">Presupuesto por Sector y Resultado</h5>
                        <table class="p-2 w-100">
                            <tr>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color: #FFF2CC">COD</th>
                                <th class="text-center w-30 border p-2 bold-h4" style="background-color: #FFF2CC">Resultado</th>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto Global</th>
                                <th class="text-center w-20 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto Financiado</th>
                                <th class="text-center w-20 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto por Financiar</th>
                            </tr>
                            <tr>
                                <td class="text-center border p-2">codigo del sector del resultado</td>
                                <td class="text-center border p-2">nombre resultado</td>
                                <td class="text-center border p-2">$5158</td>
                                <td class="text-center border p-2">$848</td>
                                <td class="text-center border p-2">$56488</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center border p-2">Total</td>
                                <td class="text-center border p-2">total presupuesto global</td>
                                <td class="text-center border p-2">total presupuesto financiado</td>
                                <td class="text-center border p-2">total presupuesto por financiar</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-incomes3" role="tabpanel">
                    <div class="pl-2">
                        <h4 class="bold-h4 p-2" style="color:#38A1F3">INGRESOS</h4>
                        <h5 class="bold-h4 ">Presupuesto Financiado versus Aportes Recibidos ( Efectivo y Especies Valoradas)</h5>
                        <table class="p-2 w-100">
                            <tr>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color: #FFF2CC">Tipo</th>
                                <th class="text-center border p-2 bold-h4" style="background-color: #FFF2CC">Financiador</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto
                                    Financiado
                                </th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Efectivo</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Especies
                                    Valoradas
                                </th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Aportes en
                                    Pendiente
                                </th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Proyecto</th>
                            </tr>
                            <tr>
                                <td class="text-center border p-2">tipo de financiador</td>
                                <td class="text-center border p-2">nombre financiador</td>
                                <td class="text-center border p-2">$5158</td>
                                <td class="text-center border p-2">$848</td>
                                <td class="text-center border p-2">$56488</td>
                                <td class="text-center border p-2">$56488</td>
                                <td class="text-center border p-2">nombre proyecto</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center border p-2">Total</td>
                                <td class="text-center border p-2">total presupuesto financiado</td>
                                <td class="text-center border p-2">total efectivo</td>
                                <td class="text-center border p-2">total especies valoradas</td>
                                <td class="text-center border p-2">total aportes en pendiente</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-expenses1" role="tabpanel">
                    <div class="pl-2">
                        <h4 class="bold-h4 p-2" style="color:#38A1F3">EGRESOS</h4>
                        <h5 class="bold-h4">Ejecución Total por Sectores</h5>
                        <table class="p-2  w-100">
                            <tr>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color: #FFF2CC">COD</th>
                                <th class="text-center w-20 border p-2 bold-h4" style="background-color: #FFF2CC">Sector</th>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Ejecución Efectivo</th>
                                <th class="text-center w-20 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Ejecución Especies Valoradas</th>
                                <th class="text-center w-20 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Comprometido</th>
                                <th class="text-center w-10 border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Total Ejecutado</th>
                            </tr>
                            <tr>
                                <td class="text-center border p-2">codigo sector</td>
                                <td class="text-center border p-2">nombre sector</td>
                                <td class="text-center border p-2">$5158</td>
                                <td class="text-center border p-2">$848</td>
                                <td class="text-center border p-2">$56488</td>
                                <td class="text-center border p-2">$83783648</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center border p-2">Total</td>
                                <td class="text-center border p-2">$total ejecucion efectivo</td>
                                <td class="text-center border p-2">$total ejecucion especies valoradas</td>
                                <td class="text-center border p-2">$total comprometido</td>
                                <td class="text-center border p-2">$total ejecutado</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-expenses2" role="tabpanel">
                    <div class="pl-2">
                        <h4 class="bold-h4 p-2" style="color:#38A1F3">EGRESOS</h4>
                        <h5 class="bold-h4">Ejecución con relación al Presupuesto Global</h5>
                        <table class="p-2 w-100">
                            <tr>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color: #FFF2CC">COD</th>
                                <th class="text-center border p-2 bold-h4" style="background-color: #FFF2CC">Sector</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto Global
                                </th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Ejecución Efectivo</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Ejecución Especies Valoradas</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Comprometido</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Saldo</th>
                            </tr>
                            <tr>
                                <td class="text-center border p-2">codigo sector</td>
                                <td class="text-center border p-2">nombre sector</td>
                                <td class="text-center border p-2">$5158</td>
                                <td class="text-center border p-2">$848</td>
                                <td class="text-center border p-2">$56488</td>
                                <td class="text-center border p-2">$83783648</td>
                                <td class="text-center border p-2">$83783648</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center border p-2">Total</td>
                                <td class="text-center border p-2">$total ejecucion efectivo</td>
                                <td class="text-center border p-2">$total ejecucion especies valoradas</td>
                                <td class="text-center border p-2">$total comprometido</td>
                                <td class="text-center border p-2">$total ejecutado</td>
                                <td class="text-center border p-2">$total saldo</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-expenses3" role="tabpanel">
                    <div class="pl-2">
                        <h4 class="bold-h4 p-2" style="color:#38A1F3">EGRESOS</h4>
                        <h5 class="bold-h4">Ejecución con relación al Presupuesto Financiado</h5>
                        <table class="p-2 w-100">
                            <tr>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color: #FFF2CC">COD</th>
                                <th class="text-center border p-2 bold-h4" style="background-color: #FFF2CC">Sector</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto Global
                                </th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Ejecución Efectivo</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Ejecución Especies Valoradas</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Comprometido</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Saldo</th>
                            </tr>
                            <tr>
                                <td class="text-center border p-2">codigo sector</td>
                                <td class="text-center border p-2">nombre sector</td>
                                <td class="text-center border p-2">$5158</td>
                                <td class="text-center border p-2">$848</td>
                                <td class="text-center border p-2">$56488</td>
                                <td class="text-center border p-2">$83783648</td>
                                <td class="text-center border p-2">$83783648</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center border p-2">Total</td>
                                <td class="text-center border p-2">$total ejecucion efectivo</td>
                                <td class="text-center border p-2">$total ejecucion especies valoradas</td>
                                <td class="text-center border p-2">$total comprometido</td>
                                <td class="text-center border p-2">$total ejecutado</td>
                                <td class="text-center border p-2">$total saldo</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-expenses4" role="tabpanel">
                    <div class="pl-2">
                        <h4 class="bold-h4 p-2" style="color:#38A1F3">EGRESOS</h4>
                        <h5 class="bold-h4">Ejecución en relación a los Aportes Recibidos ( Efectivo y Especies Valoradas)</h5>
                        <table class="p-2  w-100">
                            <tr>
                                <th class="text-center border p-2 bold-h4" style="background-color: #FFF2CC">Tipo</th>
                                <th class="text-center border p-2 bold-h4" style="background-color: #FFF2CC">Financiador</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto Financiado</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Efectivo Recibido</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd"> Especies Valoradas Recibidas</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Efectivo Ejecutado</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd"> Especies Valoradas Ejecutadas</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Comprometidos</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">% Ejecución al Presupuesto Financiado</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">% Ejecución a Valores Recibidos</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Proyecto</th>
                            </tr>
                            <tr>
                                <td class="text-center border p-2">tipo de financiador</td>
                                <td class="text-center border p-2">nombre financiador</td>
                                <td class="text-center border p-2">$5158</td>
                                <td class="text-center border p-2">$848</td>
                                <td class="text-center border p-2">$56488</td>
                                <td class="text-center border p-2">$83783648</td>
                                <td class="text-center border p-2">$83783648</td>
                                <td class="text-center border p-2">$83783648</td>
                                <td class="text-center border p-2">45%</td>
                                <td class="text-center border p-2">23%</td>
                                <td class="text-center border p-2">nombre del poryecto</td>

                            </tr>
                            <tr>
                                <td colspan="2" class="text-center border p-2">Total</td>
                                <td class="text-center border p-2">$total presupuesto finnanciado</td>
                                <td class="text-center border p-2">$total efectivo recibido</td>
                                <td class="text-center border p-2">$total especies valoradas recibidas</td>
                                <td class="text-center border p-2">$total efectivo ejecutado</td>
                                <td class="text-center border p-2">$total especies valoradas ejecutadas</td>
                                <td class="text-center border p-2">$total comprometido</td>
                                <td class="text-center border p-2">% Ejecución al Presupuesto Financiado</td>
                                <td class="text-center border p-2">% Ejecución a Valores Recibidos</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-expenses5" role="tabpanel">
                    <div class="pl-2">
                        <h4 class="bold-h4 p-2" style="color:#38A1F3">EGRESOS</h4>
                        <h5 class="bold-h4">Ejecución en relación a Resultados ( Efectivo y Especies Valoradas-Comprometido)</h5>
                        <table class="p-2  w-100">
                            <tr>
                                <th class="text-center w-15 border p-2 bold-h4" style="background-color: #FFF2CC">COD</th>
                                <th class="text-center border p-2 bold-h4" style="background-color: #FFF2CC">Resultado</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Presupuesto</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Financiamiento</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Efectivo Ejecutado</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd"> Especies Valoradas Ejecutadas</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Comprometidos</th>
                                <th class="text-center border p-2 bold-h4" style="background-color:#833C0C; color:#fffffd">Total Ejecución</th>
                            </tr>
                            <tr>
                                <td class="text-center border p-2">codigo de sector del rsultado</td>
                                <td class="text-center border p-2">nombre resultado</td>
                                <td class="text-center border p-2">$5158</td>
                                <td class="text-center border p-2">$848</td>
                                <td class="text-center border p-2">$56488</td>
                                <td class="text-center border p-2">$83783648</td>
                                <td class="text-center border p-2">$83783648</td>
                                <td class="text-center border p-2">$83783648</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center border p-2">Total</td>
                                <td class="text-center border p-2">$total presupuesto</td>
                                <td class="text-center border p-2">$total financiamiento</td>
                                <td class="text-center border p-2">$total efectivo ejecutado</td>
                                <td class="text-center border p-2">$total especies valoradas ejecutadas</td>
                                <td class="text-center border p-2">$total comprometido</td>
                                <td class="text-center border p-2">$total ejecucion</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

