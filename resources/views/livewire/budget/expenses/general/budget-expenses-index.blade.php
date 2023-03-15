<div>
    <div class="d-flex flex-wrap">
        <div class="flex-grow-1 w-33 mr-2">
            <div class="panel-container">
                <div class="panel-content">
                    <div class="card">
                        <div class="panel-tag">
                            <div class="d-flex flex-wrap">
                                <div class="p-3">
                                    <x-label-section>Estructura</x-label-section>
                                </div>
                                <div class="ml-auto p-3">
                                    <button wire:click="addProgram()"
                                            class="btn btn-xs btn-success waves-effect waves-themed">{{trans('general.add') .'-'.trans('general.program')}} </button>
                                </div>
                            </div>
                        </div>
                        <div class="frame-wrap w-100">
                            <div class="accordion" id="budgetStructure">
                                @forelse($programs->where('parent_id',null) as $pr)
                                    <div class="card" wire:key="field-{{ $pr->id }}">
                                        <div class="card-header" id="program{{$pr->code}}">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#collapse{{$pr->code}}"
                                               aria-expanded="false"
                                               aria-controls="collapse{{$pr->code}}">
                                                {{trans('general.program').' '. $pr->code .' '.$pr->name}}
                                                <span class="ml-auto">
                                                    <span class="collapsed-reveal">
                                                        <i class="fal fa-minus-circle text-danger"></i>
                                                    </span>
                                                    <span class="collapsed-hidden">
                                                        <i class="fal fa-plus-circle text-success"></i>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                        <div id="collapse{{$pr->code}}" class="collapse" aria-labelledby="program{{$pr->code}}" data-parent="#budgetStructure" style=""
                                             wire:ignore.self>
                                            <div class="card-body">
                                                <div class="panel-container show">
                                                    <div class="panel-content">
                                                        <div class="card-title">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    {{trans('general.actions')}}
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <a href="javascript:void(0);" class="mr-2" wire:click="updateProgram({{ $pr->id }})">
                                                                        <i class="fas fa-pencil-alt mr-1 text-info" data-toggle="tooltip"
                                                                           data-placement="top" title="" data-original-title="Editar {{$pr->name}}">
                                                                        </i>
                                                                    </a>
                                                                    @if($pr->childs->count()<1)
                                                                        <a href="javascript:void(0);" class="mr-2" wire:click="deleteProgram({{ $pr->id }})">
                                                                            <i class="fas fa-trash mr-1 text-danger" data-toggle="tooltip"
                                                                               data-placement="top" title="" data-original-title="Eliminar {{$pr->name}}">
                                                                            </i>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel-tag">
                                                            <div class="d-flex flex-wrap">
                                                                <div class="p-3">
                                                                    <x-label-section> Sub Programas</x-label-section>
                                                                </div>
                                                                <div class="ml-auto p-3">
                                                                    <button wire:click="addSubProgram({{ $pr->id }}, '{{ $pr->name }}')"
                                                                            class="btn btn-xs btn-success waves-effect waves-themed">{{trans('general.add') .'-'.trans('general.subprogram')}} </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion accordion-outline" id="js_demo_accordion-{{$pr->code}}">
                                                            @forelse($programs->where('parent_id',$pr->id) as $subpro)
                                                                <div class="card" wire:key="field-{{ $pr->id }}" wire:ignore.self>
                                                                    <div class="card-header">
                                                                        <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse"
                                                                           data-target="#js_demo_accordion-3{{$subpro->code}}" aria-expanded="false" wire:ignore.self>
                                                                            <i class="fal fa-file-medical-alt width-2 fs-xl"></i>
                                                                            {{trans('general.subprogram').' '. $subpro->code .' '. $subpro->name}}
                                                                            <span class="ml-auto">
                                                                                <span class="collapsed-reveal">
                                                                                    <i class="fal fa-minus fs-xl"></i>
                                                                                </span>
                                                                                <span class="collapsed-hidden">
                                                                                    <i class="fal fa-plus fs-xl"></i>
                                                                                </span>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <div id="js_demo_accordion-3{{$subpro->code}}" class="collapse" data-parent="#js_demo_accordion-{{$pr->code}}"
                                                                         style=""
                                                                         wire:ignore.self>
                                                                        <div class="card-header">
                                                                            <div class="card-title">
                                                                                <div class="d-flex flex-wrap w-100">
                                                                                    <div class="ml-2">
                                                                                        {{trans('general.actions')}}
                                                                                    </div>
                                                                                    <div class="ml-auto">
                                                                                        <a href="javascript:void(0);" class="mr-2" wire:click="updateSubProgram({{ $subpro->id }})">
                                                                                            <i class="fas fa-pencil-alt mr-1 text-info" data-toggle="tooltip"
                                                                                               data-placement="top" title="" data-original-title="Editar SubPrograma">
                                                                                            </i>
                                                                                        </a>
                                                                                        @if($subpro->childs->count()<1)
                                                                                            <a href="javascript:void(0);" class="mr-2"
                                                                                               wire:click="deleteProgram({{ $subpro->id }})">
                                                                                                <i class="fas fa-trash mr-1 text-danger" data-toggle="tooltip"
                                                                                                   data-placement="top" title="" data-original-title="Eliminar SubPrograma">
                                                                                                </i>
                                                                                            </a>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-flex flex-wrap">
                                                                                <div class="p-3">
                                                                                    <x-label-section>Actividades Administrativas</x-label-section>
                                                                                </div>
                                                                                <div class="ml-auto p-3">
                                                                                    <button wire:click="addActivity({{ $subpro->id }}, '{{ $subpro->name }}')"
                                                                                            class="btn btn-xs btn-success waves-effect waves-themed">{{trans('general.add') .'-'.trans('general.activity')}} </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <ul class="list-group list-group-flush">
                                                                            @forelse($programs->where('parent_id',$subpro->id) as $activity)
                                                                                <li class="list-group-item" style="display: flex">{{$activity->name}}
                                                                                    <a href="{{route('budgets.createBudgetGeneralExpenses',['budgetGeneralExpensesStructure'=>$activity])}}"
                                                                                       class="mr-2 ml-auto"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="top" title=""
                                                                                       data-original-title="{{ trans('budget.budget_items') }}">
                                                                                        <i class="fas fa-money-bill"></i>
                                                                                    </a>
                                                                                    <a href="javascript:void(0);" class="mr-2"
                                                                                       wire:click="updateActivity({{ $activity->id }})">
                                                                                        <i class="fas fa-pencil-alt mr-1 text-info" data-toggle="tooltip"
                                                                                           data-placement="top" title="" data-original-title="Editar Actividad">
                                                                                        </i>
                                                                                    </a>
                                                                                    @if($activity->accounts->count()<1)
                                                                                        <a href="javascript:void(0);" class="mr-2"
                                                                                           wire:click="deleteProgram({{ $activity->id }})">
                                                                                            <i class="fas fa-trash mr-1 text-danger" data-toggle="tooltip"
                                                                                               data-placement="top" title="" data-original-title="Eliminar Actividad">
                                                                                            </i>
                                                                                        </a>
                                                                                    @endif
                                                                                </li>
                                                                            @empty
                                                                                <div class="p-3">
                                                                                    <x-label-detail> No existen Actividades de {{$subpro->name}}</x-label-detail>
                                                                                </div>
                                                                            @endforelse
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <div class="p-3">
                                                                    <x-label-detail> No existen subProgramas de {{$pr->name}}</x-label-detail>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-3">
                                        <x-label-detail> No existen Programas creados</x-label-detail>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-grow-1 w-65 ml-2">
            @if($viewAdd)
                <livewire:budget.expenses.general.budget-create-expense-structure :transaction="$transaction"/>
            @endif
        </div>
    </div>
</div>
@push('page_script')
    <script>
        window.addEventListener('loadAreas', event => {
            $('#select-responsible').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
                // @this.set('responsibleUnit', $(this).val());
                window.livewire.emitTo('budget.expenses.general.budget-create-expense-structure', 'loadResponsibleUnit', {responsibleUnit: $(this).val()});

            });

            $('#select-executor').select2({
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
                window.livewire.emitTo('budget.expenses.general.budget-create-expense-structure', 'loadResponsibleUnit', {executingUnit: $(this).val()});
            });
        });
    </script>
@endpush
