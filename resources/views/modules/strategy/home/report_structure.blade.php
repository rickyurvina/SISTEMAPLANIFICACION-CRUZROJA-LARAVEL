@extends('layouts.admin')

@section('title', trans('general.module_strategy'))

@section('content')
    <div class="d-flex ml-auto w-5">
        <a href="{{route('report.structure_excel')}}" class="color-success-500"><span class="fas fa-file-excel fa-2x"></span> {{ trans('general.excel') }}</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table  m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th class="text-primary">name_program</th>
                    <th class="text-primary">code_program</th>
                    <th class="text-primary">name_result</th>
                    <th class="text-primary">code_result</th>
                    <th class="text-primary">code_indicator</th>
                    <th class="text-primary">Nombre Indicador</th>
                </tr>
                </thead>
                <tbody>
                @foreach($measures as $measure)
                    <tr>
                        <td>{{$measure->indicatorable->parent->name}}</td>
                        <td>{{$measure->indicatorable->parent->code}}</td>
                        <td>{{$measure->indicatorable->name}}</td>
                        <td>{{$measure->indicatorable->code}}</td>
                        <td>{{$measure->code}}</td>
                        <td>
                         <span>
                             <i class="{{$measure->unit->getIcon() }}"></i>
                              {{$measure->name}}
                        </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('page_script')
    <script>
        $('subheader').hide();
    </script>
@endpush