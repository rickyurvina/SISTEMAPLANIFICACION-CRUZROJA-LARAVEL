<div class="flex-grow-1 w-35" style="overflow: hidden auto">
    <div class="pl-2 content-detail mt-2">
        <x-label-section>{{ trans_choice('general.details', 2) }}</x-label-section>
    </div>
    <div class="pl-2 content-detail">
        @include('modules.project.activity.details')
        @include('modules.project.activity.register_time')
        @include('modules.project.activity.integration_strategy')
        @include('modules.project.activity.variables_weight')
        @include('modules.project.activity.location')
    </div>
    <hr>
    <div class="pl-2 content-detail">
        <div class="d-flex flex-wrap mt-2">
            <small style="color: rgb(107, 119, 140);
                                                                                                    padding-top: 2px;
                                                                                                    white-space: nowrap;
                                                                                                    margin-top: 0px;
                                                                                                    font-size: 12px;
                                                                                                    line-height: 1.33333;">
                {{trans('general.created_at')}}: {{$task->created_at->format('j F, Y')}}
            </small>
        </div>
        <div class="d-flex flex-wrap mt-2">
            <small style="color: rgb(107, 119, 140);
                                                                                                    padding-top: 2px;
                                                                                                    white-space: nowrap;
                                                                                                    margin-top: 0px;
                                                                                                    font-size: 12px;
                                                                                                    line-height: 1.33333;">
                {{trans('general.updated_at')}}: {{$task->updated_at->format('j F, Y')}}
            </small>
        </div>
    </div>
</div>