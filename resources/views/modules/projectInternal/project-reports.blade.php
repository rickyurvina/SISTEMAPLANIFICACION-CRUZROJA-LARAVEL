@extends('modules.projectInternal.project')

@section('title', trans('poa.card_reports'))


@section('project-page')
    <h1 class="subheader-title p-2">
        <i class="fal fa-table text-primary"></i> Informes del Proyecto
    </h1>
    <div class="row p-2">
        @foreach($cardReports as $cardReport)
            <div class="col-sm-3 mb-2">
                <div class="card">
                    <a href="{{ route($cardReport['ruta'],$project->id) }}">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $cardReport['titulo'] }}</h5>
                            <p class="card-text">{{$cardReport['descripcion']}}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('page_script')
    <script>

    </script>
@endpush