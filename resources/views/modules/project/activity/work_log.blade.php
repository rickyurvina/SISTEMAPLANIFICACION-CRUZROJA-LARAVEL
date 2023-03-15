<div>
    @forelse($workLogs->take($workLogCount) as $workLog)
        <div class="row mt-1 mb-1"
             style=" box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);">
            <div class="col-1 mt-2">
                @if($workLog->user->picture)
                    <span class="mr-1 ml-2">
                                                                             <img src="http://cre.test/img/user.svg"
                                                                                  class="rounded-circle width-2">
                                                                        </span>
                @else
                    <span class="mr-1 ml-2">
                                                                                 <img src="http://cre.test/img/user_off.png"
                                                                                      class="rounded-circle width-2">
                                                                           </span>
                @endif
            </div>
            <div class="col-11">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap p-2 pb-0">
                            <div class="w-auto mr-2">
                                <strong class="font-weight-bold">
                                    {{$workLog->user->getFullName() ?? ''}}
                                </strong>
                                <strong>
                                    registró
                                </strong>
                            </div>
                            <div class="w-auto ml-2 mr-2"
                                 style="margin-top:-1.5% !important;">
                                <div class="d-flex flex-wrap">
                                    <div class="w-80">
                                        <livewire:components.input-text
                                                :modelId="$workLog->id"
                                                class="\App\Models\Projects\Activities\TaskWorkLog"
                                                field="value"
                                                :title="false"
                                                defaultValue="{{$workLog->value}}"
                                                eventLivewire="workLogEdited"
                                                :key="time().$workLog->id"/>
                                    </div>
                                    <div class="w-auto">
                                        <label class="mt-2">h</label></div>
                                </div>
                            </div>
                            <div class="w-auto">
                                {{$workLog->created_at ? $workLog->created_at->format('j F, Y'):''}}
                                {{$workLog->created_at ? $workLog->created_at->format('g:i A'):''}}
                                <a class="p-3"
                                   href="javascript:void(0)"
                                   wire:click="deleteWorkLog({{$workLog->id}})">
                                    <i class="fas fa-trash mr-1 text-danger"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title=""
                                       data-original-title="Eliminar"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        No se han registrado avances de tiempo
    @endforelse
</div>
@if($workLogs->count()>=$workLogCount && $workLogs->count()>0)
    <div class="col-12">
        <div class="p-3 text-center">
            <a href="javascript:void(0);"
               wire:click="chargeWorkLog"
               class="btn-link font-weight-bold">{{trans('general.see_more')}}
                ({{$this->workLogs->count()-$workLogCount}})</a>f
        </div>
    </div>
@else
    <div class="col-12">
        <div class="p-3 text-center">
            <a href="javascript:void(0);"
               wire:click="chargeWorkLog({{true}})"
               class="btn-link font-weight-bold">{{trans('general.cancel')}}</a>
        </div>
    </div>
@endif