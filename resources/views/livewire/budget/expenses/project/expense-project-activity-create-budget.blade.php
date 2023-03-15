<div>
    <div wire:ignore.self class="modal fade fade" id="budget-expense-project-create" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">

        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4"><i class="fas fa-plus-circle text-success"></i> {{ trans('budget.new_item_expenses') }}</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($activity->indicator)
                        <div class="row">
                            <div class="col-12">
                                <div class="col-md-12 table-responsive">
                                    <table class="table  m-0">
                                        <tbody>
                                        <tr>
                                            <td class="w-10">Clave Presupuestaria</td>
                                            <td colspan="2" class="fs-2x fw-700 w-auto" id="budget_item_code">{{$budgetItem}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered detail-table">
                                        <tbody>
                                        <tr>
                                            <td class="w-10">Objetivo Estratègico</td>
                                            <td class="w-5"> {{$this->activity->indicator->indicatorable->parent->parent->parent->code}}</td>
                                            <td> {{$this->activity->indicator->indicatorable->parent->parent->parent->name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-10">Objetivo Específico</td>
                                            <td class="w-5"> {{$this->activity->indicator->indicatorable->parent->parent->code}}</td>
                                            <td> {{$this->activity->indicator->indicatorable->parent->parent->name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-10">Program</td>
                                            <td class="w-5">  {{$this->activity->indicator->indicatorable->parent->code}}</td>
                                            <td> {{$this->activity->indicator->indicatorable->parent->name}}</td>
                                        </tr>

                                        <tr>
                                            <td class="w-10">Resultado Estratégico</td>
                                            <td class="w-5"> {{$this->activity->indicator->indicatorable->code}}</td>
                                            <td> {{$this->activity->indicator->indicatorable->name}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <table class="table table-bordered detail-table">
                                        <tbody>

                                        <tr>
                                            <td class="w-10">Proyecto</td>
                                            <td class="w-5">  {{$this->activity->project->code}}</td>
                                            <td> {{$this->activity->project->name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-10">Junta Pronvicial</td>
                                            <td class="w-5"> {{$this->activity->project->location->full_code}}</td>
                                            <td> {{$this->activity->project->location->description}}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-10">Resultado Proyecto</td>
                                            <td class="w-5"> {{$this->activity->parentOfTask->code}}</td>
                                            <td> {{$this->activity->parentOfTask->text}}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-10">Actividad</td>
                                            <td class="w-5"> {{$this->activity->code}}</td>
                                            <td> {{$this->activity->text}}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-10">Localidad</td>
                                            <td class="w-5"> {{$this->activity->location->full_code}}</td>
                                            <td> {{$this->activity->location->description}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-6">
                                <form method="post" autocomplete="off" wire:submit.prevent="submit()">
                                    <div class="row">
                                        <div class="form-group col-md-12 required col-sm-12">
                                            <label class="form-label" for="name">{{ trans('budget.item_name') }}</label><br>
                                            <input type="text" wire:model.defer="itemName" id="name" class="form-control @error('itemName') is-invalid @enderror">
                                            @error('itemName')
                                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        @foreach($fieldsOptionals as $key => $field)
                                            @switch($field['meta']['type'])
                                                @case('input')
                                                    <div class="form-group col-12 required" wire:key="field-{{ $loop->index }}">
                                                        <label class="form-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                                        <input type="{{ $field['meta']['content'] }}" wire:model="fieldsOptionals.{{ $key }}.value"
                                                               name="{{ $field['name'] }}"
                                                               readonly="{{ $field['meta']['readonly'] }}"
                                                               class="form-control">
                                                    </div>
                                                    @break
                                                @case('select')
                                                    <div class="form-group col-12 required" wire:key="field-{{ $loop->index }}">
                                                        <label class="form-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                                        <select class="select2 select2Create form-control w-100 @error('fieldsOptionals.' . $key . '.value') is-invalid @enderror"
                                                                wire:model="fieldsOptionals.{{ $key }}.value">
                                                            <option value="">{{trans('general.select')}}</option>
                                                            @foreach($field['meta']['source']['options'] as $item)
                                                                <option value="{{ $item[$field['meta']['source']['field']] }}"
                                                                        wire:key="op-{{ $loop->index }}">
                                                                    {{ $item[$field['meta']['source']['field']] . ' - ' . $item[$field['meta']['source']['field_display']] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('fieldsOptionals.' . $key . '.value')
                                                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                    </div>
                                                    @break
                                            @endswitch
                                        @endforeach
                                        @if($transaction->status instanceof \App\States\Transaction\Draft)
                                            <div class="form-group col-md-12 required">
                                                <label class="form-label" for="amount">{{ trans('budget.value') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" wire:model.defer="itemAmount" id="amount" class="form-control @error('itemAmount') is-invalid @enderror">
                                                    @error('itemAmount')
                                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        @else
                                            <div class="form-group col-md-12 required">
                                                <label class="form-label" for="amount">{{ trans('budget.value') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                        <a class="ml-2 mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="Para asignar un valor es necesario hacer una reforma">
                                                            <i class="fas fa-info mr-1 ml-1 text-warning"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="form-group col-md-12 required">
                                            <label class="form-label" for="description">{{ trans('general.description') }}</label><br>
                                            <textarea wire:model.defer="itemDescription" id="description" class="form-control @error('itemDescription') is-invalid @enderror">
                                    </textarea>
                                            @error('itemDescription')
                                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    @error('code')
                                    <div class="d-flex mt-2 ml-2">
                                        <div class="w-75">
                                            <div class="alert alert-danger align-center" role="alert" id="div_percentage_of_control">
                                                {{$message}}
                                            </div>
                                        </div>
                                    </div>
                                    @enderror
                                    <div class="modal-footer justify-content-center">
                                        <x-form.modal.footer wirecancelevent="resetForm"></x-form.modal.footer>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        $(document).ready(function () {
            $('.select2Create').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#budget-expense-project-create")
            }).on('change', function (e) {
                @this.
                set($(e.target).attr('wire:model'), e.target.value);
            });
        });
    </script>
    <script>
        window.addEventListener('loadBudgets', event => {
            $('.select2Create').select2({
                placeholder: "{{ trans('general.select') }}",
                dropdownParent: $("#budget-expense-project-create")
            }).on('change', function (e) {
                @this.
                set($(e.target).attr('wire:model'), e.target.value);
            });
        });
    </script>
@endpush
