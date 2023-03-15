<div>
    <div wire:ignore.self class="modal fade" id="project-create-stakeholder" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 70rem;">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Stakeholders</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="panel-content">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" wire:ignore>
                                <a class="nav-link active" data-toggle="tab" href="#general" role="tab" aria-selected="false">
                                    <i class="fal fa-user text-primary"></i>
                                    <span class="hidden-sm-down ml-1">{{trans('general.general_information')}}</span>
                                </a>
                            </li>
                            @if($isUpdating)
                                <li class="nav-item" wire:ignore>
                                    <a class="nav-link" data-toggle="tab" href="#actions" role="tab" aria-selected="false">
                                        <i class="fal fa-address-card"></i>
                                        <span class="hidden-sm-down ml-1">{{trans('general.actions')}}</span>
                                    </a>
                                </li>
                            @endif

                        </ul>

                        <div class="tab-content border border-top-0 p-3">
                            <div class="tab-pane fade show active" id="general" role="tabpanel" wire:ignore.self>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-3 required">
                                            <label class="form-label" for="user_id">{{ trans('general.contact') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fas fa-book-user"></i>
                                                </span>
                                                </div>
                                                <select wire:model.defer="user_id"
                                                        class="custom-select bg-transparent @error('user_id') is-invalid @enderror">
                                                    <option value=""
                                                            selected>{{ trans('general.form.select.field', ['field' => trans('general.contact')]) }}</option>
                                                    @foreach($users as $item)
                                                        <option value="{{ $item->id }}">{{ $item->getFullName() }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
                                            </div>
                                        </div>
                                        <div class="form-group col-3 required">
                                            <label class="form-label" for="interest_level">{{ trans('general.interest_level') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                  <i class="fal fa-bullseye-pointer"></i>
                                                </span>
                                                </div>
                                                <select wire:model.defer="interest_level"
                                                        class="custom-select bg-transparent @error('interest_level') is-invalid @enderror">
                                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.interest_level')]) }}</option>
                                                    <option value={{\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW}}>{{ trans('general.labels.priority2_' .\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW) }}</option>
                                                    <option value={{\App\Models\Projects\Stakeholders\ProjectStakeholder::HIGH}}>{{ trans('general.labels.priority_' .\App\Models\Projects\Stakeholders\ProjectStakeholder::HIGH) }}</option>
                                                </select>
                                                <div class="invalid-feedback">{{ $errors->first('interest_level') }}</div>
                                            </div>
                                        </div>
                                        <div class="form-group col-3 required">
                                            <label class="form-label" for="influence_level">{{ trans('general.influence_level') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fal fa-level-up"></i>>
                                                </span>
                                                </div>
                                                <select wire:model.defer="influence_level"
                                                        class="custom-select bg-transparent @error('influence_level') is-invalid @enderror">
                                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.influence_level')]) }}</option>
                                                    <option value={{\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW}}>{{ trans('general.labels.priority2_' .\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW) }}</option>
                                                    <option value={{\App\Models\Projects\Stakeholders\ProjectStakeholder::HIGH}}>{{ trans('general.labels.priority_' .\App\Models\Projects\Stakeholders\ProjectStakeholder::HIGH) }}</option>
                                                </select>
                                                <div class="invalid-feedback">{{ $errors->first('influence_level') }}</div>
                                            </div>
                                        </div>
                                        <div class="form-group col-3 required">
                                            <label class="form-label" for="priority">{{ trans('general.priority') }}</label>
                                            <div class="input-group bg-white shadow-inset-2">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                  <i class="fal fa-bookmark"></i>
                                                </span>
                                                </div>
                                                <select wire:model.defer="priority"
                                                        class="custom-select bg-transparent @error('priority') is-invalid @enderror">
                                                    <option value=""
                                                            selected>{{ trans('general.form.select.field', ['field' => trans('general.priority')]) }}</option>
                                                    <option value={{\App\Models\Projects\Stakeholders\ProjectStakeholder::URGENT}}>{{ trans('general.labels.priority_' .\App\Models\Projects\Stakeholders\ProjectStakeholder::URGENT) }}</option>
                                                    <option value={{\App\Models\Projects\Stakeholders\ProjectStakeholder::IMPORTANT}}>{{ trans('general.labels.priority_' .\App\Models\Projects\Stakeholders\ProjectStakeholder::IMPORTANT) }}</option>
                                                    <option value={{\App\Models\Projects\Stakeholders\ProjectStakeholder::HALF}}>{{ trans('general.labels.priority_' .\App\Models\Projects\Stakeholders\ProjectStakeholder::HALF) }}</option>
                                                    <option value={{\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW}}>{{ trans('general.labels.priority_' .\App\Models\Projects\Stakeholders\ProjectStakeholder::LOW) }}</option>
                                                </select>
                                                <div class="invalid-feedback">{{ $errors->first('priority') }}</div>
                                            </div>
                                        </div>

                                        @if(!is_null($strategy))
                                            <div class="form-group col-3 required">
                                                <label class="form-label" for="strategy">{{ trans('general.strategy') }}</label>
                                                <div class="input-group bg-white shadow-inset-2">
                                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                              <i class="fal fa-arrow-alt-down"></i>
                                            </span>
                                                    </div>
                                                    <input type="text" wire:model.defer="strategy" readonly="readonly" value="{{$strategy}}"
                                                           class="form-control bg-transparent">
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                    @if($isUpdating)
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label class="form-label mt-1" for="positive_impact">{{ trans('general.positive_impact') }}</label>

                                                <livewire:components.input-text-editor-inline-editor :modelId="$projectStakeholder->id"
                                                                                                     class="\App\Models\Projects\Stakeholders\ProjectStakeholder"
                                                                                                     field="positive_impact"
                                                                                                     :defaultValue="$projectStakeholder->positive_impact"
                                                                                                     :key="time().$projectStakeholder->id"/>


                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label mt-1" for="positive_impact">{{ trans('general.negative_impact') }}</label>

                                                <livewire:components.input-text-editor-inline-editor :modelId="$projectStakeholder->id"
                                                                                                     class="\App\Models\Projects\Stakeholders\ProjectStakeholder"
                                                                                                     field="negative_impact"
                                                                                                     :defaultValue="$projectStakeholder->positive_impact"
                                                                                                     :key="time().$projectStakeholder->id"/>


                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            @if($isUpdating)
                                <div class="tab-pane fade" id="actions" role="tabpanel" wire:ignore.self>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-row w-100">

                                                <x-form.modal.text type="text" id="name"
                                                                   label="{{ __('general.name').' '.trans('general.action') }}"
                                                                   class="form-group col" required="required">
                                                </x-form.modal.text>

                                                <x-form.modal.select id="owner" label="{{ trans('general.owner') }}" class="col" required="required">
                                                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.owner')]) }}</option>
                                                    @foreach($users as $item)
                                                        <option value="{{ $item->id }}">{{ strlen($item->getFullName())>45?substr($item->getFullName(),0 , 45).'...' : $item->getFullName() }}</option>
                                                    @endforeach
                                                </x-form.modal.select>

                                                <x-form.modal.select id="task_id" label="{{ trans_choice('general.result',2) }}" class="col" required="required">
                                                    <option value="">{{ trans('general.form.select.field', ['field' => trans_choice('general.result',1)]) }}</option>
                                                    @foreach($results as $item)
                                                        <option value="{{ $item->id }}">{{ strlen($item->text)>45?substr($item->text,0 , 45).'...' : $item->text  }}</option>
                                                    @endforeach
                                                </x-form.modal.select>

                                                <x-form.modal.text type="date" id="start_date_action"
                                                                   label="{{ __('general.implementation_date') }}"
                                                                   class="form-group col" required="required">
                                                </x-form.modal.text>

                                                <x-form.modal.text type="date" id="closing_date"
                                                                   label="{{ __('general.end_date') }}"
                                                                   class="form-group col" required="required">
                                                </x-form.modal.text>

                                                <div class="col-12 pb-5">
                                                    <button class="btn btn-success" type="button" id="button-addon2" wire:click="saveAction">
                                                        <i class="fa fa-plus mr2"></i> {{trans('general.add_action')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        @forelse($projectStakeholderActions as $index => $item)
                                            <div class="d-flex flex-wrap w-100" wire:ignore>
                                                <div class="w-3px" style="background-color: #FFFFFF !important;">
                                                    <div class="mt-1  dropdown-table">
                                                                                  <span class=" btn btn-xs btn-icon border-0 fs-md show-on-hover-parent open-drop"
                                                                                        data-toggle="dropdown">
                                                                                    <i class="fas fa-caret-down"></i>
                                                                                  </span>
                                                        <div class="dropdown-menu fadeindown dropdown-md m-0 p-0">
                                                            <div class="dropdown-item m-2" style="border-radius: 4px"
                                                                 wire:click="$emit(' stakeholderActionDelete', '{{ $item->id }}')">
                                                                <i class="fal fa-trash-alt mr-2"></i>{{ trans('general.delete').' '.trans('general.action') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="w-5px">
                                                    <div class="h-100 d-flex align-items-center pr-1"
                                                         style="background-color: {{ $item->color ?? '#808080' }};"></div>
                                                </div>

                                                <div class="w-25" wire:ignore wire:key="{{time().$item->id.$index}}">
                                                    <livewire:components.input-inline-edit :modelId="$item->id"
                                                                                           class="\App\Models\Projects\Stakeholders\ProjectStakeholderActions"
                                                                                           field="name"
                                                                                           :rules="'required'"
                                                                                           defaultValue="{{$item->name}}"
                                                                                           :key="time().$item->id"/>
                                                </div>
                                                <div class="w-20" wire:ignore wire:key="{{time().$item->id}}">
                                                    <livewire:components.dropdown-user :modelId="$item->id"
                                                                                       modelClass="\App\Models\Projects\Stakeholders\ProjectStakeholderActions"
                                                                                       field="user_id"
                                                                                       :key="time().$item->id"
                                                                                       :user="$item->responsible"/>

                                                </div>

                                                <div class="w-20" wire:ignore wire:key="{{time().$item->id}}">
                                                    <livewire:components.select-inline-edit :modelId="$item->id"
                                                                                            :fieldId="$item->task_id"
                                                                                            class="\App\Models\Projects\Stakeholders\ProjectStakeholderActions"
                                                                                            field="task_id"
                                                                                            value="{{$item->result->text ??''}}"
                                                                                            :selectClass="$results"
                                                                                            selectField="text"
                                                                                            :rules="$rule"
                                                                                            selectRelation="result"
                                                                                            :key="time().$item->id"/>
                                                </div>

                                                <div class="w-10" style="background-clip: padding-box;
                 border: 1px solid #E5E5E5; border-radius: 4px; height: calc(1.47em + 1rem + 2px); padding: 0.5rem 0.875rem">
                                                    <label class="form-label" for="start_date"
                                                    >{{ $item->start_date}}</label>
                                                </div>
                                                <div class="w-10" style="background-clip: padding-box;
                 border: 1px solid #E5E5E5; border-radius: 4px; height: calc(1.47em + 1rem + 2px); padding: 0.5rem 0.875rem">
                                                    <label class="form-label" for="end_date"
                                                    >{{ $item->end_date}}</label>
                                                </div>
                                                <div class="w-10" wire:ignore wire:key="{{time().$item->id}}">
                                                    <livewire:components.select-inline-edit :modelId="$item->id"
                                                                                            class="\App\Models\Projects\Stakeholders\ProjectStakeholderActions"
                                                                                            field="state"
                                                                                            value="{{$item->state??''}}"
                                                                                            :selectArray="$status"
                                                                                            :key="time().$item->id"/>

                                                </div>
                                            </div>
                                        @empty
                                            <div class="w-100">
                                                <span data-filter-tags="reports file">{{trans('general.without_actions_regsitered')}}</span>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="justify-content-center">
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary mr-1" wire:click="closeModal">
                                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                                </a>
                                <button wire:click="createStakeholder" class="btn btn-primary">
                                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

        @this.on(' stakeholderActionDelete', id => {

            Swal.fire({
                target: document.getElementById('project-create-stakeholder'),
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ trans('messages.warning.delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                if (result.value) {
                @this.call('deleteAction', id);
                }
            });
        });
        })
    </script>
@endpush