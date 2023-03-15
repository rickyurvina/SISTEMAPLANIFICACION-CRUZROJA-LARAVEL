<div wire:ignore.self class="modal fade in" id="project-change-control-detail" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        @if($activity)
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-info">
                        {{ $activity->subject?$activity->subject->name:'' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body p-3">
                        <dl class="row">
                            <dt class="col-sm-2"><h5><strong>{{ trans('general.user') }}</strong></h5></dt>
                            <dd class="col-sm-10">
                                  <span class="mr-2">
                                @if (is_object($activity->picture))
                                          <img src="{{ Storage::url($activity->causer->picture->id) }}" class="rounded-circle width-2" alt="  {{ $activity->causer->name }}">
                                      @else
                                          <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-2" alt="  {{ $activity->causer->name }}}">
                                      @endif
                                </span>
                                {{ $activity->causer->name }}
                            </dd>
                            <dt class="col-sm-2"><h5><strong>{{ trans('general.action') }}</strong></h5></dt>
                            <dd class="col-sm-10">
                                {{ $activity->description }}
                            </dd>
                            <dd class="col-sm-12">
                                @if($activity->subject_type!='App\\Models\\Projects\\ProjectFeasibility')
                                    @switch($activity->log_name)
                                        @case('updated')
                                        <hr>
                                        <h3 class="text-center"> {{trans('general.changes')}}</h3>
                                        <table class="table m-0">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <table class="table table-hover m-0">
                                                        <thead class="bg-primary-50">
                                                        <tr>
                                                            <th class="w-30"> {{trans('general.field')}}</th>
                                                            <th class="w-70"> {{trans('general.prev')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($activity->properties as $properties)
                                                            @foreach($properties as $index => $property)
                                                                @if($loop->parent->last)
                                                                    @if($index!='updated_at')
                                                                        <tr>
                                                                            <th class="w-30">
                                                                            {{$index}}
                                                                            </td>
                                                                            <th class="w-70">
                                                                            {{$property}}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>
                                                    <table class="table  m-0">
                                                        <thead class="bg-primary-50">
                                                        <tr>
                                                            <th> {{trans('general.actual')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($activity->properties as $properties)
                                                            @foreach($properties as $index => $property)
                                                                @if($loop->parent->first)
                                                                    @if($index!='updated_at')
                                                                        <tr>
                                                                            <td>
                                                                                {{$property}}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{trans('general.date')}}
                                                </td>
                                                <td colspan="2">
                                                    {{ $activity->created_at->format('F j, Y, g:i a') }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        @break
                                        @case('created')
                                        {{trans('general.date')}}: {{ $activity->created_at->format('F j, Y, g:i a') }}
                                        @break
                                        @case('deleted')
                                        <strong> {{trans('general.date')}}: </strong> {{ $activity->created_at->format('F j, Y, g:i a') }}
                                        @break
                                    @endswitch
                                @endif
                            </dd>
                        </dl>
                    </div>
                    {{--                    <x-pagination :items="$medias"/>--}}
                </div>
            </div>
        @endif
    </div>
</div>