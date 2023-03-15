@extends('modules.projectInternal.project')

@section('project-page')
<div class="p-2">

    <div class="panel-1" style="display: contents">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center text-info fs-2x fw-700">Sucesos dentro del proyecto</h2>
                    <table class="table m-0">
                        <thead>
                        <tr>
                            <th>{{ __('general.name') }}</th>
                            <th>{{ __('general.category') }}</th>
                            <th>{{trans('general.description')}}</th>
                            <th>{{ __('general.date') }}</th>
                            <th>{{ __('general.responsable') }}</th>
                        </tr>
                        </thead>
                        <tbody>
{{--                        @foreach($project->eventsProjects as $event)--}}
{{--                            <tr>--}}
{{--                                <td>{{$event->name}}</td>--}}
{{--                                <td>{{$event->category}}</td>--}}
{{--                                <td>{{$event->description}}</td>--}}
{{--                                <td>{{$event->date}}</td>--}}
{{--                                <td>{{$event->user->name}}</td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>

@endsection

