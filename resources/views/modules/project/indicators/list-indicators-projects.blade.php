<div class="pl-2 pt-2">
    <div class="content-detail">
        <div class="d-flex flex-column">
            <div class="d-flex flex-nowrap mt-2">
                <div class="w-100">
                    <div class="d-flex mr-auto">

                    </div>
                    <div class="table-responsive">
                        <table class="table w-100 m-0 " wire:loading.class.delay="opacity-50">
                            <thead>
                            <tr>
                                <th class="w-20 ">{{__('general.name')}}</th>
                                <th class="w-5 ">{{__('general.code')}}</th>
                                <th class="w-35 ">{{trans_choice('general.indicators',2)}}</th>
                                <th class="w-5 ">{{trans('general.goal')}}</th>
                                <th class="w-5 ">{{trans('general.advance')}}</th>
                                <th class="w-5 ">{{trans('general.progress')}}</th>
                                <th class="w-15">{{trans('general.responsible')}}</th>
                                <th class="w-10 text-center ">{{ trans('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="8" class="table-info h-25 text-center">
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div class="mr-1">
                                            <span> {{trans_choice('general.indicators',2)}} de {{trans_choice('general.project',1)}}</span>
                                        </div>
                                        <div class="ml-2">
                                            <a class="btn btn-success btn-xs shadow-0"
                                               style="color:white;"
                                               wire:click="$emit('show', 'App\\Models\\Projects\\Project', '{{ $project->id }}')">
                                                {{ trans('general.create') }} {{trans_choice('general.indicators',1)}}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @foreach($project->indicators as $indicator)
                                <tr>
                                    @if($loop->first)
                                        <th class="w-20  align-middle align-items-center text-center"
                                            rowspan="{{$project->indicators->count()}}">{{$project->name}}</th>
                                    @endif
                                    @include('indicator.information-indicators')
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="8" class="table-info h-25 text-center">{{trans_choice('general.indicators',2)}} de {{trans_choice('general.goals',2)}}</td>
                            </tr>
                            @foreach($objectives->sortBy('id') as $objective)
                                @foreach($objective->indicators as $indicator)
                                    <tr>
                                        @if($loop->first)
                                            <th class="align-middle align-items-center text-center"
                                                rowspan="{{$objective->indicators->count()}}">{{$objective->name}}</th>
                                        @endif
                                        @include('indicator.information-indicators')
                                    </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="8" class="table-info h-25 text-center">{{trans_choice('general.indicators',2)}}
                                    de {{trans_choice('general.result',2)}}
                                </td>
                            </tr>
                            @foreach($results as $result)
                                @foreach($result->indicators as $indicator)
                                    <tr>
                                        @if($loop->first)
                                            <th class="align-middle align-items-center text-center"
                                                rowspan="{{$result->indicators->count()}}">{{$result->text}}</th>
                                        @endif
                                        @include('indicator.information-indicators')
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

