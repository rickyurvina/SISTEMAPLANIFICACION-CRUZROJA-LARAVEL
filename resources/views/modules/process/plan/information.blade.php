@extends('modules.process.processes.process')

@section('process-page')
    <div class="panel-content mt-2">
        <div class="row">
            <div class="col-auto">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                     aria-orientation="vertical">
                    <a class="nav-link  active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-process-summary"
                       role="tab" aria-controls="v-pills-general-data" aria-selected="true">
                        <span class="hidden-sm-down ml-1"> Resumen del Proceso</span>
                    </a>
                    <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-process-sheet"
                       role="tab" aria-controls="v-pills-general-data" aria-selected="false">
                        <span class="hidden-sm-down ml-1"> Ficha del Proceso</span>
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-process-map"
                       role="tab" aria-controls="v-pills-objectives" aria-selected="false">
                        <span class="hidden-sm-down ml-1">Mapa de Proceso</span>
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-process-inputs-outputs"
                       role="tab" aria-controls="v-pills-purpose" aria-selected="false">
                        <span class="hidden-sm-down ml-1">Entradas y Salidas</span>
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-process-evaluation"
                       role="tab" aria-controls="v-pills-articulations" aria-selected="false">
                        <span class="hidden-sm-down ml-1"> Evaluación del Proceso</span>
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-process-attachments"
                       role="tab" aria-controls="v-pills-purpose" aria-selected="false">
                        <span class="hidden-sm-down ml-1">Adjuntos</span>
                    </a>
                </div>
            </div>

            <div class="col">
                <div class="tab-content pl-2 mr-0 pr-1" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-process-summary" role="tabpanel"
                         aria-labelledby="v-pills-home-tab">
                        <div class="w-100 table-responsive align-content-center">
                            <table class="table m-0 w-100">
                                <tr>
                                    <th class="bold-h4 w-15"> {{trans('general.responsible')}}</th>
                                    <th class="bold-h4 w-25"> {{trans('general.inputs')}}</th>
                                    <th class="bold-h4 w-35"> {{trans_choice('general.activities',2)}}</th>
                                    <th class="bold-h4 w-25"> {{trans('general.outputs')}}</th>
                                </tr>
                                <tr>
                                    <td>{{$process->department->name}}</td>
                                    <td>
                                        @if($process->inputs)
                                            @foreach($process->inputs as $item)
                                                <ul>
                                                    <li>{{$item}}</li>
                                                </ul>
                                            @endforeach</td>
                                    @else
                                        <span>{{trans('general.there_are_no_inputs')}}</span>
                                    @endif
                                    <td>
                                        @if($process->activitiesProcess)
                                            @foreach($process->activitiesProcess as $item)
                                                <ul>
                                                    <li>{{$item->name}}</li>
                                                </ul>
                                            @endforeach
                                        @else
                                            <span>{{trans('general.there_are_no_activities')}}</span>
                                        @endif

                                    </td>
                                    <td>
                                        @if($process->outputs)
                                            @foreach($process->outputs as $item)
                                                <ul>
                                                    <li>{{$item}}</li>
                                                </ul>
                                            @endforeach</td>
                                    @else
                                        <span>{{trans('general.there_are_no_outputs')}}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="w-100">
                            <div class="d-flex flex-nowrap">
                                <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                                    <div class="w-100">
                                        <div class="card ml-3 mr-3">
                                            <div class="d-flex justify-content-center m-5">
                                                <a class="w-33 d-sm-flex align-items-center" href="{{ route('process.showActivities',[$process->id, $page]) }}">
                                                    <div class="p-2 mr-3 bg-success-500 rounded">
                                        <span class="peity-bar" data-peity="{&quot;fill&quot;: [&quot;#fff&quot;], &quot;width&quot;: 27, &quot;height&quot;: 27 }"
                                              style="display: none;">6,4,7,5,6</span>
                                                        <svg class="peity" height="27" width="27">
                                                            <rect data-value="6" fill="#fff" x="0.539772" y="3.855514285714289" width="4.318176" height="23.133085714285713"></rect>
                                                            <rect data-value="4" fill="#fff" x="5.937492000000001" y="11.566542857142858" width="4.318175999999999"
                                                                  height="15.422057142857144"></rect>
                                                            <rect data-value="7" fill="#fff" x="11.335212000000002" y="0" width="4.318175999999999" height="26.9886"></rect>
                                                            <rect data-value="5" fill="#fff" x="16.732932" y="7.711028571428571" width="4.318176000000001"
                                                                  height="19.27757142857143"></rect>
                                                            <rect data-value="6" fill="#fff" x="22.130652" y="3.855514285714289" width="4.318176000000001"
                                                                  height="23.133085714285713"></rect>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <label class="fs-sm mb-0">Actividades</label>
                                                        <h4 class="font-weight-bold mb-0">{{$process->activitiesProcess->count()}}</h4>
                                                    </div>
                                                </a>
                                                <a class="w-33 d-sm-flex align-items-center" href="{{ route('process.showIndicators',[$process->id, $page]) }}">
                                                    <div class="p-2 mr-3 bg-warning-300 rounded">
                                        <span class="peity-bar" data-peity="{&quot;fill&quot;: [&quot;#fff&quot;], &quot;width&quot;: 27, &quot;height&quot;: 27 }"
                                              style="display: none;">3,4,3,5,5</span>
                                                        <svg class="peity" height="27" width="27">
                                                            <rect data-value="3" fill="#fff" x="0.539772" y="10.795440000000003" width="4.318176" height="16.19316"></rect>
                                                            <rect data-value="4" fill="#fff" x="5.937492000000001" y="5.39772" width="4.318175999999999"
                                                                  height="21.590880000000002"></rect>
                                                            <rect data-value="3" fill="#fff" x="11.335212000000002" y="10.795440000000003" width="4.318175999999999"
                                                                  height="16.19316"></rect>
                                                            <rect data-value="5" fill="#fff" x="16.732932" y="0" width="4.318176000000001" height="26.9886"></rect>
                                                            <rect data-value="5" fill="#fff" x="22.130652" y="0" width="4.318176000000001" height="26.9886"></rect>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <label class="fs-sm mb-0">Indicadores</label>
                                                        <h4 class="font-weight-bold mb-0"> {{$process->indicators->count()}}</h4>
                                                    </div>
                                                </a>
                                                <a class="w-33 d-sm-flex align-items-center"
                                                   href="{{ route('process.showConformities',[$process->id, \App\Models\Process\Process::PHASE_ACT]) }}">
                                                    <div class="p-2 mr-3 bg-info-200 rounded">
                                        <span class="peity-bar" data-peity="{&quot;fill&quot;: [&quot;#fff&quot;], &quot;width&quot;: 27, &quot;height&quot;: 27 }"
                                              style="display: none;">3,4,5,8,2</span>
                                                        <svg class="peity" height="27" width="27">
                                                            <rect data-value="3" fill="#fff" x="0.539772" y="16.867875" width="4.318176" height="10.120725"></rect>
                                                            <rect data-value="4" fill="#fff" x="5.937492000000001" y="13.4943" width="4.318175999999999" height="13.4943"></rect>
                                                            <rect data-value="5" fill="#fff" x="11.335212000000002" y="10.120725" width="4.318175999999999"
                                                                  height="16.867875"></rect>
                                                            <rect data-value="8" fill="#fff" x="16.732932" y="0" width="4.318176000000001" height="26.9886"></rect>
                                                            <rect data-value="2" fill="#fff" x="22.130652" y="20.24145" width="4.318176000000001" height="6.747150000000001"></rect>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <label class="fs-sm mb-0">No conformidades</label>
                                                        <h4 class="font-weight-bold mb-0">{{$process->nonConformities->count()}}</h4>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-grow-1 w-100 mt-4 p-2">
                                        <x-label-section>{{ trans('general.comments') }}</x-label-section>
                                        <livewire:components.comments :modelId="$process->id" class="\App\Models\Process\Process" identifier="information"
                                                                      :key="time().$process->id"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-process-sheet" role="tabpanel"
                         aria-labelledby="v-pills-problem-identified">
                        <div class="content-detail w-100">
                            <div class="d-flex flex-wrap">
                                <div class="w-25">
                                    <x-label-detail>{{trans('general.code')}}</x-label-detail>
                                </div>
                                <div class="w-75">
                                    <x-content-detail> {{$process->code}}</x-content-detail>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap w-100">
                                <div class="w-25">
                                    <x-label-detail>{{trans('general.name')}}</x-label-detail>
                                </div>
                                <div class="w-75">
                                    <x-content-detail> {{$process->name }}</x-content-detail>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="w-25">
                                    <x-label-detail>{{trans('general.description')}}</x-label-detail>
                                </div>
                                <div class="w-75">
                                    <x-content-detail> {{$process->description}}</x-content-detail>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="w-25">
                                    <x-label-detail>{{trans('general.type')}}</x-label-detail>
                                </div>
                                <div class="w-75">
                                    <x-content-detail>
                                        <span class="badge badge- {{ \App\Models\Process\Process::TYPES_BG[$process->type] }} badge-pill">{{ $process->type }}</span>
                                    </x-content-detail>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="w-25">
                                    <x-label-detail>{{trans_choice('general.department',1)}}</x-label-detail>
                                </div>
                                <div class="w-75">
                                    <x-content-detail>{{$process->department->name }}</x-content-detail>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="w-25">
                                    <x-label-detail>{{ trans('general.process_owner') }}</x-label-detail>
                                </div>
                                <div class="w-75">
                                    <x-content-detail>
                                          <span class="mr-2 ml-2">
                                                @if (is_object($process->owner->picture))
                                                  <img src="{{ Storage::url($process->picture->id) }}" class="rounded-circle width-2" alt="{{ $process->owner->name }}">
                                              @else
                                                  <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-2" alt="{{ $process->owner->name }}">
                                              @endif
                                            </span>
                                        {{$process->owner->getFullName() }}</x-content-detail>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-process-map" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div class="row w-100 justify-content-center">
                            <livewire:components.files :modelId="$process->id"
                                                       model="{{\App\Models\Process\Process::class}}"
                                                       folder="Process/{{$process->id}}/processMaps"
                                                       accept=".png, .jpg, .jpeg"
                                                       :key="time().$process->id"
                                                       identifier="map"
                            />
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-process-inputs-outputs" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div class="w-100">
                            <livewire:process.create-inputs-outputs :processId="$process->id"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-process-evaluation" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div class="w-100">
                            <livewire:process.process-evaluation :processId="$process->id"/>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-process-attachments" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div class="w-100">
                            <livewire:components.files :modelId="$process->id"
                                                       model="{{\App\Models\Process\Process::class}}"
                                                       folder="Process/{{$process->id}}/processAttachments"
                                                       :key="time().$process->id"
                                                       identifier="attachment"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
