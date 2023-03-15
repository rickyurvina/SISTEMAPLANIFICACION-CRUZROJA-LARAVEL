<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">

    <style>

        .logo {
            margin: auto;
            text-align: center;
        }

        .title-project {
            text-transform: uppercase;
            color: #000000;
            text-align: center;
        }

        .bg-red {
            background-color: #D52B1E;
        }

        .color-white {
            color: #FFFFFF;
        }

        .color-black {
            color: #000000;
        }

        .text-center {
            text-align: center !important;
        }

        .summary-table {
            border: 1px solid;
        }

        .summary-table td,
        .summary-table th {
            padding: 0 10px;
            text-align: left;
            border: 1px solid;
        }

        .w-100 {
            width: 100%;
        }

        .index a {
            text-decoration: none;
            color: #000000;
        }

        .index a:hover {
            text-decoration: underline;
        }

        .index li {
            margin: 15px 0;
        }

        table {
            border-spacing: 0;
        }

        td > img {
            margin-left: 30px;
        }

        .content-index a {
            color: #000000;
            text-decoration: none;
            line-height: 3em;
        }
    </style>


    <title></title>
</head>

<body>


<div class="logo">
    <img src="{{ asset('img/logo_cre.jpg') }}" alt="logo"/>
</div>

<h1 class="title-project">
    {{$project->name}}
</h1>


<table class="summary-table w-100">
    <tbody>
    <tr>
        <th class="bg-red" scope="row">
            <h3 class="color-white">
                Asunto:
            </h3>
        </th>
        <td>
            <p>
                Acta de Constitución del Proyecto
            </p>
        </td>
    </tr>
    <tr>
        <th class="bg-red" scope="row">
            <h3 class="color-white">
                Financiador(es):
            </h3>
        </th>
        <td>
            <ul>
                @foreach($project->funders as $funder)
                    <li>
                        <p>
                            {{$funder->name}}
                        </p>
                    </li>
                @endforeach
            </ul>
        </td>
    </tr>
    <tr>
        <th class="bg-red" scope="row">
            <h3 class="color-white">
                Monto del Proyecto:
            </h3>
        </th>
        <td>
            <p>
                {{'$'.number_format($project->estimated_amount,2) }}
            </p>
        </td>
    </tr>
    <tr>
        <th class="bg-red" scope="row">
            <h3 class="color-white">
                Coordinador del Proyecto:
            </h3>
        </th>
        <td>
            <p>
                {{--                {{ $project->members->first()->name }}--}}
            </p>
        </td>
    </tr>
    <tr>
        <th class="bg-red" scope="row">
            <h3 class="color-white">
                Fecha:
            </h3>
        </th>
        <td>
            <p>
                {{ now() }}
            </p>
        </td>
    </tr>

    </tbody>
</table>

<div style="page-break-after: always;"></div>
<h2 class="text-center color-black">
    ACTA DE CONSTITUCIÓN DEL PROYECTO
</h2>
<h3>Contenido</h3>
<ol class="content-index">
    <li>
        <a href="#id-problem">
            IDENTIFICACIÓN DEL PROBLEMA
        </a>
    </li>
    <li>
        <a href="#location">
            LOCALIDAD
        </a>
    </li>
    <li>
        <a href="#objectives">
            OBJETIVOS DEL PROYECTO
        </a>
    </li>
    <li>
        <a href="#date-start-end">
            FECHA DE INICIO Y FIN
        </a>
    </li>
    <li>
        <a href="#expected-benefit-project">
            BENEFICIO ESPERADO DEL PROYECTO
        </a>
    </li>
    <li>
        <a href="#work-team">
            EQUIPO DE TRABAJO
        </a>
    </li>
    <li>
        <a href="#stakeholders">
            ACTORES CLAVE
        </a>
    </li>
    <li>
        <a href="#risk">
            RIESGOS
        </a>
    </li>
    <li>
        <a href="#schedule">
            CRONOGRAMA
        </a>
    </li>
    <li>
        <a href="#budget">
            PRESUPUESTO
        </a>
    </li>
    <li>
        <a href="#requirements">
            REQUISITOS DE APROBACIÓN DEL PROYECTO
        </a>
    </li>
    <li>
        <a href="#approval">
            APROBACIONES
        </a>
    </li>
</ol>
<div style="page-break-after: always;"></div>
<h2 id="id-problem">1. IDENTIFICACIÓN DEL PROBLEMA</h2>
{!! $project->problem_identified !!}

<br/>
<h2 id="location">2. LOCALIDAD</h2>

@if($project->locations->count()>0)
    <ol>
        @foreach($project->locations as $item)
            <li>
                <p>
                    {{$item->getPath()}}
                </p>
            </li>
        @endforeach
    </ol>
@else
    <div role="alert">
        <strong>No existen </strong>Localizaciones
    </div>
@endif

<br/>
<h2 id="objectives">3. OBJETIVOS</h2>
<h3>OBJETIVOS DEL PROYECTO</h3>
@if($project->objectives->count()>0)
    <ul role="tree">

        @foreach($project->objectives as $index =>$objective)
            <li role="treeitem">
                {{$objective->name}}
                <ul>
                    @foreach($objective->results as $index =>$result)
                        <li>
                            {{$result->name}}
                            <ul>
                                @foreach($result->childs as $index =>$task)
                                    <li>
                                        {{$task->text}}
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
@else
    <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
        <strong>No existen </strong>{{trans('general.objectivesSpecifics')}}
    </div>
@endif

<br/>
<h2 id="date-start-end">4. FECHA DE INICIO Y FIN</h2>
<table class="summary-table w-100">
    <tbody>
    <tr>
        <th scope="row" class="bg-red">
            <strong class="color-white">
                FECHA INICIO:
            </strong>
        </th>
        <td>
            <p>
                {{ $project->start_date }}
            </p>
        </td>
    </tr>
    <tr>
        <th scope="row" class="bg-red">
            <strong class="color-white">
                FECHA FIN:
            </strong>
        </th>
        <td>
            <p>
                {{ $project->end_date }}
            </p>
        </td>
    </tr>
    </tbody>
</table>

<br/>
<h2 id="expected-benefit-project">5. BENEFICIO ESPERADOS DEL PROYECTO</h2>

{!! $project->description_beneficiaries !!}

@if($project->beneficiaries->count()>0)
    <ol>
        @foreach($project->beneficiaries as $item)
            <li>
                <p>
                    {{$item->types->description??''}}: {{$item->amount}}
                </p>
            </li>
        @endforeach
    </ol>
@else
    <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
        <strong>No existe </strong>beneficiarios.
    </div>
@endif

<br/>
<h2 id="work-team">6. EQUIPO DE TRABAJO</h2>
@if($project->members->count()>0)
    <table class="summary-table w-100">
        <thead>
        <tr>
            <th scope="col" class="bg-red text-center">
                <h3 class="color-white">
                    N°
                </h3>
            </th>
            <th scope="col" class="bg-red text-center">
                <h3 class="color-white">
                    Nombre
                </h3>
            </th>
            <th scope="col" class="bg-red text-center">
                <h3 class="color-white">
                    Cargo Dentro del Proyecto
                </h3>
            </th>
            <th scope="col" class="bg-red text-center">
                <h3 class="color-white">
                    Lugar(SC, JP o terreno)
                </h3>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($project->members as $item)
            <tr>
                <th scope="row" class="text-center">
                    <p>
                        {{ ++$loop->index }}
                    </p>
                </th>
                <td class="text-center">
                    <p>
                        {{ $item->user->getFullName() }}
                    </p>
                </td>
                <td class="text-center">
                    <p>
                        {{ $item->role->name }}
                    </p>
                </td>
                <td class="text-center">
                    <p>
                        {{ $item->place->description }}
                    </p>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
        <strong>No existe </strong>equipo de proyecto definido.
    </div>
@endif

<br/>
<h2 id="stakeholders">7. ACTORES CLAVE</h2>
@if($project->stakeholders->count()>0)
    <table class="summary-table w-100">
        <thead class="bg-primary-50">
        <tr>
            <th scope="col" class="bg-red text-center">
                <h3 class="color-white">
                    {{trans('general.assigned_to')}}
                </h3>
            </th>
            <th scope="col" class="bg-red text-center">
                <h3 class="color-white">
                    {{trans('general.priority')}}
                </h3>
            </th>
            <th scope="col" class="bg-red text-center">
                <h3 class="color-white">
                    {{trans('general.strategy')}}
                </h3>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($project->stakeholders as $item)
            <tr>
                <td class="text-center">
                    <p>
                        {{ $item->interested->getFullName()??'' }}
                    </p>
                </td>
                <td class="text-center">
                    <p>
                        @switch($item->priority)
                            @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::URGENT)
                            <span style="color: red">
                                {{ trans('general.labels.priority_' . $item->priority) }}
                            </span>
                            @break
                            @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::IMPORTANT)
                            <span style="color: red">
                                ! {{ trans('general.labels.priority_' . $item->priority) }}
                            </span>
                            @break
                            @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::HALF)
                            <span style="color: green">
                                - {{ trans('general.labels.priority_' . $item->priority) }}
                            </span>
                            @break
                            @case(\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW)
                            <span style="color: blue">
                                &#8595; {{ trans('general.labels.priority_' . $item->priority) }}
                            </span>
                            @break
                        @endswitch
                    </p>
                </td>
                <td class="text-center">
                    <p>
                        {{ $item->strategy }}
                    </p>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
        <strong>No existen </strong>actores clave.
    </div>
@endif

<br/>
<h2 id="risk">8. RIESGOS</h2>
@if($project->risks->count()>0)
    <ul>
        @foreach($project->risks as $item)
            <li>
                {{$item->name}}
            </li>
        @endforeach
    </ul>
@else
    <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
        <strong>No existen </strong>riesgos creados.
    </div>
@endif

<br/>
<h2 id="schedule">9. CRONOGRAMA</h2>
@php
    $maxCols=8;
     $max=8;
    $aux=$time;
    $k=1;
     $l=1;
     $aux2=0;
       if ($maxCols>=$time)
         {
             $maxCols=$time;
         }
@endphp
@while($maxCols<=$time && $k<=$time)
    <table class="summary-table w-100 border">
        <thead>
        <tr>
            <th scope="col" class="bg-red" style="width: 30%">
                <h3 class="color-white border">
                    Nombre Resultado
                </h3>
            </th>
            @for($i=1; $i<=min($max,$aux);$i++)
                <th scope="col" class="bg-red border">
                    <h3 class="color-white text-center">
                        Mes-{{$k}}
                    </h3>
                    @php
                        $k++;
                    @endphp
                </th>
            @endfor
        </tr>
        </thead>
        <tbody>
        @if($project->objectives->pluck('results')->count()>0)
            @foreach($project->objectives as $objective)
                @foreach($objective->results as $result)
                    <tr>
                        <td class="text-truncate-md text-truncate">{{$result->text}}</td>
                        @php
                            $l=1+$aux2;
                        @endphp
                        @for($i=1; $i<=min($max,$aux);$i++)
                            <td class="border">
                                @isset($plans[$result->id][$l])
                                    &#10004;
                                @else
                                    -
                                @endisset
                            </td>
                            @php
                                $l++;
                            @endphp
                        @endfor
                    </tr>
                @endforeach
            @endforeach
        @else
            <div class="alert border-danger bg-transparent text-danger mt-2 mb-2 w-80" role="alert">
                <strong>No existe </strong>cronograma de actividades.
            </div>
        @endif
        </tbody>
    </table>
    @php
        $maxCols=$maxCols+8;
        if ($maxCols>$time){
            $maxCols=$time;
        }
         $aux=$aux-$max;
        $aux2=$aux2+8;
    @endphp
@endwhile
<br/>
<h2 id="budget">10. PRESUPUESTO</h2>
{{'$'.number_format($project->estimated_amount,2) }}

<br/>
<h2 id="requirements">11. REQUISITOS DE APROBACIÓN DEL PROYECTO</h2>

<br/>
<h2 id="approval">12. APROBACIONES</h2>

</body>
</html>