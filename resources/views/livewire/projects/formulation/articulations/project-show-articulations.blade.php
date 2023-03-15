<div>
    <div class="row w-100 mb-2">
        <x-label-section> {{trans_choice('general.articulations',0)}}
            <x-tooltip-help message="{{$messagesList->where('code','articulaciones')->first()->description}}"></x-tooltip-help>
        </x-label-section>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#project-articulate-modal"
           data-id="{{$project->id}}" class="btn btn-success btn-sm mb-2 mt-2 mr-2 ml-auto">
            <span class="fas fa-plus mr-1"></span>{{trans('general.articulate')}}
        </a>
    </div>
    <div class="card">
        @if($articulations->count()>0)
            <div class="table-responsive">
                <table class="table m-0 border-1">
                    <thead class="bg-primary-50">
                    <tr>
                        <th colspan="2" class="text-center">Articulaciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articulations->groupBy('plan_target_id') as $articulations2)
                        @foreach($articulations2->groupBy('prj_project_id')  as  $index => $articulation)
                            @foreach($articulation as $planArticulation)

                                <tr>
                                    @if($loop->index==0 && $loop->parent->index==0)
                                        <td rowspan="{{$articulation->count()}}" class="bg-gray-100 color-info-600">{{$planArticulation->targetPlan->name}}</td>
                                    @endif
                                    <td>{{$planArticulation->targetPlanDetail->name}}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else

            <x-empty-content>
                <x-slot name="title">
                    No existen articulaciones para el proyecto
                </x-slot>
            </x-empty-content>

        @endif
    </div>
    <div wire:ignore.self>
        <livewire:projects.formulation.articulations.project-articulate/>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleProjectArticulateModal', () => $('#project-articulate-modal').modal('toggle'));
        $('#project-articulate-modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('articulateProject', id);
        });
    </script>
@endpush