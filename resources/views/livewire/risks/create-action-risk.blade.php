<div>
    <div class="row">
        <div class="card p-2 mb-2">
            <div class="form-row w-100" wire:ignore.self>

                <x-form.modal.text type="text" id="name"
                                   label="{{ __('general.name').' '.trans('general.action') }}"
                                   class="form-group col" required="required">
                </x-form.modal.text>

                <x-form.modal.select id="user_id" label="{{ trans('general.owner') }}" class="col" required="required">
                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.owner')]) }}</option>
                    @foreach($users as $item)
                        <option value="{{ $item->id }}">{{ strlen($item->getFullName())>45?substr($item->getFullName(),0 , 45).'...' : $item->getFullName() }}</option>
                    @endforeach
                </x-form.modal.select>
                <x-form.modal.select id="type" label="{{ trans('general.type') }}" class="col" required="required">
                    <option value="">{{ trans('general.form.select.field', ['field' => trans('general.type')]) }}</option>
                    @foreach(\App\Models\Risk\RiskAction::TYPES as $item)
                        <option value="{{ $item }}">{{ $item}}</option>
                    @endforeach
                </x-form.modal.select>
            </div>

            <div class="form-row w-100" wire:ignore.self>

                @if($class==\App\Models\Projects\Project::class)
                    <x-form.modal.select id="task_id" label="{{ trans_choice('general.result',2) }}" class="col" required="required">
                        <option value="">{{ trans('general.form.select.field', ['field' => trans_choice('general.result',1)]) }}</option>
                        @foreach($tasks as $item)
                            <option value="{{ $item->id }}">{{ strlen($item->text)>45?substr($item->text,0 , 45).'...' : $item->text  }}</option>
                        @endforeach
                    </x-form.modal.select>
                @endif

                <x-form.modal.text type="date" id="start_date"
                                   label="{{ __('general.implementation_date') }}"
                                   class="form-group col" required="required">
                </x-form.modal.text>

                <x-form.modal.text type="date" id="end_date"
                                   label="{{ __('general.end_date') }}"
                                   class="form-group col" required="required">
                </x-form.modal.text>
                <div class="col-12 pb-5 text-center">
                    <button class="btn btn-primary" type="button" id="button-addon2" wire:click="saveAction">
                        <i class="fa fa-save mr2"></i> {{trans('general.add_action')}}
                    </button>
                </div>
            </div>


        </div>

    </div>
    <div class="row">
        @if($actions->count()>0 )
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                    <tr class="text-center">
                        <th class="w-auto table-th">{{__('general.name')}}</th>
                        <th class="w-20 table-th">{{__('general.responsable')}}</th>
                        @if($class==\App\Models\Projects\Project::class)
                            <th class="w-10 table-th">Resultado</th>
                        @endif
                        <th class="w-10 table-th">{{__('general.start_date')}}</th>
                        <th class="w-10 table-th">{{__('general.end_date')}}</th>
                        <th class="w-5 table-th">{{__('general.state')}}</th>
                        <th class="w-5 table-th">{{__('general.type')}}</th>
                        <th class="w-10 table-th"><a href="#">{{ trans('general.actions') }} </a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($actions as $index => $item)
                        <tr class="tr-hover" wire:loading.class.delay="opacity-50" wire:key="{{time().$item->id.$index}}">
                            <td>
                                <div wire:key="{{time().$index}}" wire:ignore>
                                    <livewire:components.input-inline-edit :modelId="$item->id"
                                                                           class="\App\Models\Risk\RiskAction"
                                                                           field="name"
                                                                           :rules="'required'"
                                                                           defaultValue="{{$item->name}}"
                                                                           :key="time().$item->id"/>
                                </div>
                            </td>
                            <td>
                                <div wire:key="{{time().$index}}" wire:ignore>
                                    <livewire:components.select-inline-edit :modelId="$item->id"
                                                                            :fieldId="$item->user_id"
                                                                            class="\App\Models\Risk\RiskAction"
                                                                            field="user_id"
                                                                            value="{{$item->user?$item->user->getFullName():''}}"
                                                                            :selectClass="$users"
                                                                            selectField="name"
                                                                            selectRelation="user"
                                                                            :key="time().$item->id"/>
                                </div>
                            </td>
                            @if($class==\App\Models\Projects\Project::class)
                                <td>
                                    <div wire:key="{{time().$index}}" wire:ignore>
                                        <livewire:components.select-inline-edit :modelId="$item->id"
                                                                                :fieldId="$item->task_id"
                                                                                class="\App\Models\Risk\RiskAction"
                                                                                field="task_id"
                                                                                value="{{$item->result->text??''}}"
                                                                                :selectClass="$tasks"
                                                                                selectField="text"
                                                                                selectRelation="result"
                                                                                :key="time().$item->id"/>
                                    </div>
                                </td>
                            @endif
                            <td>
                                {{ $item->start_date->format('j F')}}
                            </td>
                            <td>
                                {{ $item->end_date->format('j F')}}
                            </td>
                            <td>
                                <div wire:key="{{time().$index}}" wire:ignore>
                                    <livewire:components.select-inline-edit :modelId="$item->id"
                                                                            class="\App\Models\Risk\RiskAction"
                                                                            field="state"
                                                                            value="{{$item->state??''}}"
                                                                            :selectArray="$status"
                                                                            :key="time().$item->id"/>
                                </div>
                            </td>
                            <td>
                                <div wire:key="{{time().$index}}" wire:ignore>
                                    <livewire:components.select-inline-edit :modelId="$item->id"
                                                                            class="\App\Models\Risk\RiskAction"
                                                                            field="type"
                                                                            value="{{$item->type??''}}"
                                                                            :selectArray="\App\Models\Risk\RiskAction::TYPES"
                                                                            :key="time().$item->id"/>
                                </div>
                            </td>
                            <td>
                                <a href="#" wire:click="generateDeleteAction({{ $item->id }})" class="p-3">
                                    <i class="fas fa-trash-alt mr-1 text-danger"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Eliminar"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="w-100">
                <x-empty-content>
                    <x-slot name="title">
                        {{trans('general.without_actions_regsitered')}}
                    </x-slot>
                </x-empty-content>
            </div>
        @endif
    </div>
</div>
@push('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

        @this.on('deleteActionRisk', id => {
            Swal.fire({
                target: document.getElementById('edit-modal-risk'),
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