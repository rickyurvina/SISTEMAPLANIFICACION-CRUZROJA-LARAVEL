<div wire:ignore.self class="modal fade in" id="poa-change-control-detail" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        @if($activity)
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-info">
                        {{ $activity->subject ? $activity->subject->name:'' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-2"><h5><strong>{{ trans('general.user') }}</strong></h5></dt>
                            <dd class="col-sm-10">
                                {{ $activity->causer->name }}
                            </dd>
                            <dt class="col-sm-2"><h5><strong>{{ trans('general.action') }}</strong></h5></dt>
                            <dd class="col-sm-10">
                                {{ $activity->description }}
                            </dd>

                            <dt class="col-sm-2"><h5><strong>{{ trans('general.name') }}</strong></h5></dt>
                            <dd class="col-sm-10">
                                {{ $activity->subject ? $activity->subject->name :''}}
                            </dd>
                            <dt class="col-sm-2"><h5><strong>{{ trans('general.code') }}</strong></h5></dt>
                            <dd class="col-sm-10">
                                {{ $activity->subject ? $activity->subject->code :'' }}
                            </dd>
                            <dt class="col-sm-2"><h5><strong>{{ trans('general.date') }}</strong></h5></dt>
                            <dd class="col-sm-10">
                                {{ $activity->created_at->format('F j, Y, g:i a') }}
                            </dd>
                        </dl>
                        @if($activity->properties && isset($activity->changes['attributes']))
                            <h3 class="text-center">{{trans('general.attributes')}}</h3>
                            <table class="table m-0">
                                <thead class="bg-primary-50">
                                <tr>
                                    <th class="w-30">{{trans('general.field')}}</th>
                                    <th class="w-70">{{trans('general.prev')}}</th>
                                    <th>{{trans('general.actual')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($activity->changes['attributes'] as $key => $val)
                                    @if(isset($activity->changes['old'])  && isset($activity->changes['attributes']) )
                                        <tr>
                                            <td>{{"$key"}}</td>
                                            <td>{{ $activity->changes['old'][$key] }}</td>
                                            <td>{{ is_array( $activity->changes['attributes'][$key]) ? json_encode( $activity->changes['attributes'][$key]): $activity->changes['attributes'][$key]}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        @if($activity->properties)
                            <h3 class="text-center">{{trans('general.changes')}}</h3>
                            <table class="table m-0">
                                <thead class="bg-primary-50">
                                <tr>
                                    <th class="w-30">Key</th>
                                    <th class="w-70">{{trans('general.value')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($activity->properties['attributes']  as $key => $val)
                                    <tr>
                                        <td>{{"$key"}}</td>
                                        <td>{{$val}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        @if($activity->properties &&  $activity->getExtraProperty('browser_information'))
                            <h3 class="text-center">Información del navegador</h3>

                            <table class="table m-0">
                                <tbody>
                                <tr>
                                    <td class="w-30">{{trans('general.IP')}}</td>
                                    <td class="w-30"> {{$activity->getExtraProperty("browser_information")['ip'] ??''}} </td>
                                </tr>

                                <tr>
                                    <td class="w-30">os</td>
                                    <td class="w-30"> {{$activity->getExtraProperty("browser_information")['os'] ??''}} </td>
                                </tr>
                                <tr>
                                    <td class="w-30">url</td>
                                    <td class="w-30"> {{$activity->getExtraProperty("browser_information")['url'] ??''}} </td>
                                </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>