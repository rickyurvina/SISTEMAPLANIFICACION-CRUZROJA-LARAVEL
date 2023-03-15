<div>
    @if($piatReport)
        <x-label-section>{{ trans('poa.piat_matrix_report_divider') }}</x-label-section>
        <div class="section-divider"></div>
        <div class="d-flex flex-wrap">
            <div class="form-group w-20">
                <label class="form-label fw-700"
                       for="accomplished">{{ trans('poa.piat_matrix_report_placeholder_accomplished') }}</label>
                <div class="mt-2">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="accomplished_yes"
                               name="accomplished" wire:click="$set('accomplished', true)"
                               @if ($piatReport->accomplished==true) checked @endif>
                        <label class="custom-control-label"
                               for="accomplished_yes">{{ trans('general.yes') }}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="accomplished_no"
                               name="accomplished" wire:click="$set('accomplished', false)"
                               @if ($piatReport->accomplished==false) checked @endif>
                        <label class="custom-control-label"
                               for="accomplished_no">{{ trans('general.no') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group w-20">
                <label class="form-label fw-700"
                       for="reportDate">{{ trans('poa.piat_matrix_create_placeholder_date') }}</label>
                <livewire:components.input-inline-edit :modelId="$piatReport->id"
                                                       class="{{\App\Models\Poa\Piat\PoaActivityPiatReport::class}}"
                                                       field="date"
                                                       type="date"
                                                       :rules="'required'"
                                                       :defaultValue="$piatReport->date"
                                                       :key="time().$piatReport->id"/>
            </div>
            <div class="form-group w-20">
                <label class="form-label fw-700 timepicker"
                       for="reportInitTime">{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}</label>
                <livewire:components.input-inline-edit :modelId="$piatReport->id"
                                                       class="{{\App\Models\Poa\Piat\PoaActivityPiatReport::class}}"
                                                       field="initial_time"
                                                       type="time"
                                                       :rules="'required|before:'.$piatReport->end_time"
                                                       :defaultValue="$piatReport->initial_time"
                                                       :key="time().$piatReport->id"/>
            </div>
            <div class="form-group w-20">
                <label class="form-label fw-700 timepicker"
                       for="reportEndTime">{{ trans('poa.piat_matrix_create_placeholder_end_time') }}</label>
                <livewire:components.input-inline-edit :modelId="$piatReport->id"
                                                       class="{{\App\Models\Poa\Piat\PoaActivityPiatReport::class}}"
                                                       field="end_time"
                                                       type="time"
                                                       :rules="'required|after:'.$piatReport->initial_time"
                                                       :defaultValue="$piatReport->end_time"
                                                       :key="time().$piatReport->id"/>
            </div>
            @if( $this->piatReport->approved_by!=-1)
                <div class="form-group w-20 pl-2">
                    <x-label-section>{{ trans('poa.piat_matrix_create_placeholder_approved_by')}}</x-label-section>
                    <x-content-detail>{{ $this->piatReport->responsableToApprove->getFullName()}}</x-content-detail>
                </div>
            @endif
            <div class="form-group w-100">
                <label class="form-label fw-700"
                       for="description">{{ trans('general.description') }}</label>
                <livewire:components.input-text-editor-inline-editor :modelId="$piatReport->id"
                                                                     class="{{\App\Models\Poa\Piat\PoaActivityPiatReport::class}}"
                                                                     field="description"
                                                                     :defaultValue="$piatReport->description"
                                                                     :key="time().$piatReport->id"/>
            </div>
        </div>
        <x-label-section>{{ trans('poa.piat_matrix_report_divider_evaluation') }}
        </x-label-section>
        <div class="section-divider"></div>
        <div class="d-flex flex-wrap w-100">
            <div class="d-flex flex-wrap w-50">
                <label class="form-label fw-700"
                       for="description">{{ trans('poa.piat_matrix_report_placeholder_positive_evaluation') }}</label>
                <livewire:components.input-text-editor-inline-editor :modelId="$piatReport->id"
                                                                     class="{{\App\Models\Poa\Piat\PoaActivityPiatReport::class}}"
                                                                     field="positive_evaluation"
                                                                     :defaultValue="$piatReport->positive_evaluation"
                                                                     :key="time().$piatReport->id"/>
            </div>
            <div class="d-flex flex-wrap w-50">
                <label class="form-label fw-700"
                       for="description">{{ trans('poa.piat_matrix_report_placeholder_inprove_evaluation') }}</label>
                <livewire:components.input-text-editor-inline-editor :modelId="$piatReport->id"
                                                                     class="{{\App\Models\Poa\Piat\PoaActivityPiatReport::class}}"
                                                                     field="evaluation_for_improvement"
                                                                     :defaultValue="$piatReport->evaluation_for_improvement"
                                                                     :key="time().$piatReport->id"/>
            </div>
        </div>
    @else
        <div class="card">
            <x-empty-content>
                <x-slot name="img">
                    <i class="fas fa-ballot-check" style="color: #2582fd;"></i>
                </x-slot>
                <x-slot name="title">
                    {{ trans('general.reports') }}
                </x-slot>
                <x-slot name="info">
                    {{ trans('messages.info.empty_reports') }}
                </x-slot>
                <div class="d-flex flex-column">
                    <a href="javascript:void(0);" wire:click="generateReport"><i class="fas fa-ballot-check"></i> {{ trans('poa.generate_report') }}
                    </a>
                </div>
            </x-empty-content>
        </div>
        <div class="col-12" wire:loading wire:target="generateReport">
            <div class="frame-wrap">
                <div class="border-0 p-3">
                    <div class="d-flex align-items-center">
                        <strong>Generado Reporte de la Matriz...</strong>
                        <div class="spinner-border ml-auto color-success-700" role="status" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
