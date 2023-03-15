<h1 class="subheader-title p-2">
    <i class="fal fa-table text-primary"></i> PLANIFICACIÓN PRESUPUESTARIA
</h1>
<div class="card">
    <select name="" class="custom-select @error('') is-invalid @enderror" id="">
        <option value="">Unidad Ejecutora </option>
        {{--        @foreach($project->funders as $funder)--}}
        {{--            <option value="{{ $funder->id }}">{{ $funder->name }}</option>--}}
        {{--        @endforeach--}}
    </select>
    <div class="d-flex position-relative ml-auto w-100">
        <label for="search">
            <i class="fal fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
        </label>
        <input type="text"
               id="search"
               name="search"
               value="<?php echo e(request()->get('search', '')); ?>"
               wire:model="search"
               class="form-control bg-subtlelight pl-6"
               placeholder="<?php echo e(trans('general.search_placeholder')); ?>">

    </div>
    <table class="border ex-e-table m-4">
        <tr class="border text-center header">
            <th class="border text-center" colspan="10">ESTRUCTURA PRAGMÁTICA</th>
            <th class="border text-center" colspan="5">ALINEACIÓN CON CLASIFICADOR PRESUPUESTARIO</th>
            <th class="border text-center" rowspan="2">COMPETENCIA</th>
            <th class="border text-center" colspan="4">ALINEACIÓN CON CLASIFICADOR ORIENTACIÓN GASTO</th>
            <th class="border text-center" colspan="3">ALINEACIÓN CON CLASIFICADOR GEOGRÁFICO</th>
            <th class="border text-center" rowspan="2">FUENTE FINANCIMIENTO</th>
            <th class="border text-center" rowspan="2">ORGANISMO</th>
            <th class="border text-center" rowspan="2">PARTIDA PRESUPUESTARIA</th>
            <th class="border text-center" rowspan="2">TOTAL PRESUPUESTO</th>
            <th class="border text-center" rowspan="2">ENE</th>
            <th class="border text-center" rowspan="2">FEB</th>
            <th class="border text-center" rowspan="2">MAR</th>
            <th class="border text-center" rowspan="2">I TRIMESTRE</th>
            <th class="border text-center" rowspan="2">ABR</th>
            <th class="border text-center" rowspan="2">MAY</th>
            <th class="border text-center" rowspan="2">JUN</th>
            <th class="border text-center" rowspan="2">II TRIMESTRE</th>
            <th class="border text-center" rowspan="2">JUL</th>
            <th class="border text-center" rowspan="2">AGO</th>
            <th class="border text-center" rowspan="2">SEP</th>
            <th class="border text-center" rowspan="2">III TRIMESTRE</th>
            <th class="border text-center" rowspan="2">OCT</th>
            <th class="border text-center" rowspan="2">NOV</th>
            <th class="border text-center" rowspan="2">DIC</th>
            <th class="border text-center" rowspan="2">IV TRIMESTRE</th>
        </tr>
        <tr class="border text-center header">
            <th class="border text-center">Objetivo Estratégico</th>
            <th class="border text-center">Objetivo Específico</th>
            <th class="border text-center">Programa</th>
            <th class="border text-center">Junta Provincial</th>
            <th class="border text-center">Resultado</th>
            <th class="border text-center">Indicador</th>
            <th class="border text-center">Actividad</th>
            <th class="border text-center">Localidad</th>
            <th class="border text-center">Item Presupuestario</th>
            <th class="border text-center">Fuente de Financiamiento</th>
            <th class="border text-center">Naturaleza</th>
            <th class="border text-center">Grupo</th>
            <th class="border text-center">Subgrupo</th>
            <th class="border text-center">Item</th>
            <th class="border text-center">Descripción</th>
            <th class="border text-center">Orientación</th>
            <th class="border text-center">Dirección</th>
            <th class="border text-center">Categoría</th>
            <th class="border text-center">Sub-categoría</th>
            <th class="border text-center">Provincia</th>
            <th class="border text-center">Canton</th>
            <th class="border text-center">Parroquia</th>
        </tr>
        <tr  class="border text-center">
            <td class="border text-center">Objetivo Estratégico</td>
            <td class="border text-center">Objetivo Específico</td>
            <td class="border text-center">Programa</td>
            <td class="border text-center">Junta Quito</td>
            <td class="border text-center">Resultado</td>
            <td class="border text-center">Indicador</td>
            <td class="border text-center">Actividad</td>
            <td class="border text-center">Quito</td>
            <td class="border text-center">Item Presupuestario</td>
            <td class="border text-center">Cruz Roja Alemana</td>
            <td class="border text-center">Naturaleza</td>
            <td class="border text-center">Grupo</td>
            <td class="border text-center">Subgrupo</td>
            <td class="border text-center">Item</td>
            <td class="border text-center">Descripción</td>
            <td class="border text-center">Competencia</td>
            <td class="border text-center">Orientación</td>
            <td class="border text-center">Dirección</td>
            <td class="border text-center">Categoría</td>
            <td class="border text-center">Sub-categoría</td>
            <td class="border text-center">Pihincha</td>
            <td class="border text-center">Quito</td>
            <td class="border text-center">La Gasca</td>
            <td class="border text-center">Cruz Roja Espanola</td>
            <td class="border text-center">DM Quito</td>
            <td class="border text-center">01.01.01.999.001.001.5.51.01.05.000.99.99.99.99.00.00.00.000.7380000</td>
            <td class="border text-center">78387</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
            <td class="border text-center">12</td>
        </tr>
    </table>
</div>
