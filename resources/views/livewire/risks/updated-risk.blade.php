<div>
    <div wire:ignore.self class="modal fade" id="edit-modal-risk" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ trans('general.edit').' '.trans_choice('general.risks', 1) }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                            wire:click="closeModal">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="panel-content">

                        <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#identification"
                                                    wire:ignore wire:key="field-1">
                                    <i class="fal fa-home mr-1"></i>{{ trans('general.identification') }}</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#analysis" wire:ignore
                                                    wire:key="field-2">
                                    <i class="fas fa-chart-line mr-1"></i>{{ trans('general.analysis') }}</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#risk_actions" wire:ignore
                                                    wire:key="field-3">
                                    <i class="fas fa-folder-open mr-1"></i>{{ trans('general.actions') }}</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="identification" role="tabpanel" wire:ignore>
                                <form wire:submit.prevent="submit" method="post" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <x-form.modal.text id="name"
                                                               label="{{ trans('general.name') }}"
                                                               required="required" class="form-group col-12 required"
                                                               placeholder="{{ __('general.form.enter', ['field' => __('general.name')]) }}">
                                            </x-form.modal.text>
                                            <x-form.modal.textarea id="description"
                                                                   label="{{ __('general.description') }}"
                                                                   class="form-group col-12 required">
                                            </x-form.modal.textarea>
                                            @if($classifications)
                                                <x-form.modal.select id="classification" label="{{ trans('general.classification') }}"
                                                                     class="form-group col-12 required">
                                                    <option
                                                            value="">{{ trans('general.form.select.field', ['field' => trans('general.classification')]) }}</option>
                                                    @foreach($classifications as $item)
                                                        <option
                                                                value="{{ $item->id }}" {{ (collect(old('classifications'))->contains($item->id)) ? 'selected':'' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </x-form.modal.select>
                                            @endif
                                            <x-form.modal.text id="identification_date"
                                                               type="date"
                                                               label="{{ trans('general.identification_date') }}"
                                                               class="form-group col-4"
                                                               placeholder="{{ __('general.form.enter', ['field' => __('general.identification_date')]) }}">
                                            </x-form.modal.text>
                                            <x-form.modal.text id="incidence_date"
                                                               type="date"
                                                               label="{{ trans('general.incidence_date') }}"
                                                               class="form-group col-4"
                                                               placeholder="{{ __('general.form.enter', ['field' => __('general.incidence_date')]) }}">
                                            </x-form.modal.text>
                                            <x-form.modal.text id="closing_date"
                                                               type="date"
                                                               label="{{ trans('general.closing_date') }}"
                                                               class="form-group col-4"
                                                               placeholder="{{ __('general.form.enter', ['field' => __('general.closing_date')]) }}">
                                            </x-form.modal.text>
                                            <x-form.modal.text id="cost"
                                                               type="number"
                                                               label="{{ trans('general.cost') }}"
                                                               class="form-group col-4"
                                                               placeholder="{{ __('general.form.enter', ['field' => __('general.cost')]) }}">
                                            </x-form.modal.text>
                                            <x-form.modal.text id="cause"
                                                               type="text"
                                                               label="{{ trans('general.cause') }}"
                                                               class="form-group col-4"
                                                               placeholder="{{ __('general.form.enter', ['field' => __('general.cause')]) }}">
                                            </x-form.modal.text>
                                            <x-form.inputs.select id="state" wire:model.defer="state"
                                                                  label="{{ trans('general.state').' '.trans_choice('general.risks',1) }}"
                                                                  class="col-4">

                                                @foreach(\App\Models\Risk\Risk::STATES as $item)
                                                    <option value="{{ $item }}">{{ $item}}</option>
                                                @endforeach
                                            </x-form.inputs.select>
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <x-form.modal.footer wirecancelevent="closeModal"></x-form.modal.footer>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="analysis" role="tabpanel" wire:ignore.self>
                                <div class="row mt-2 p-4">
                                    <div class="d-flex flex-wrap w-100">
                                        <div class="d-flex flex-column w-30">
                                            <x-label-section>{{ trans('general.impact') }} Eje Y</x-label-section>
                                            <div class="text-left">
                                                <input type="text" wire:model="impact" readonly
                                                       class="form-control-sm form-control-plaintext">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column w-40">
                                            <x-label-section>{{ trans('general.probability_of_occurrence') }} Eje X</x-label-section>
                                            <div class="text-left">
                                                <input type="text" wire:model="probability" readonly
                                                       class="form-control-sm form-control-plaintext">
                                            </div>
                                        </div>
                                        <div class="d-flex ml-auto flex-column w-30">
                                            <x-label-section>{{ trans('general.urgency') }}</x-label-section>
                                            <div class="text-left">
                                                <input type="text" wire:model="urgency" readonly
                                                       class="form-control-sm form-control-plaintext">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="chartRisk"
                                     style="width: 100% !important; height: 600px !important;font-size: xx-small !important;"></div>
                                <div class="card mt-2">
                                    <div class="table-responsive">
                                        <table class="table  m-0">
                                            <thead class="bg-primary-50">
                                            <tr>
                                                <th class="text-center" colspan="3">Descripción de Escalas</th>
                                            </tr>
                                            <tr>
                                                <th class="w-5">#</th>
                                                <th class="text-center w-25">{{ trans('general.risk_probability_scale') }}</th>

                                                <th class="text-center w-auto">{{ trans('general.risk_impact_scale') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($scalesX)
                                                @for($i=0; $i<10;$i++)
                                                    <tr>
                                                        <td>{{$i+1}}</td>
                                                        <td>{{$scalesX[$i]}}</td>
                                                        <td>{{$scalesY[$i]}}</td>
                                                    </tr>
                                                @endfor
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="risk_actions" role="tabpanel" wire:ignore.self>
                                <div class="p-4 mt-2">
                                    @if($risk)
                                        <div wire:key="actions1">
                                            <livewire:risks.create-action-risk :risk="$risk->id" :modelId="$model->id"
                                                                               :class="$class" :key="time().$riskId"/>
                                        </div>
                                    @endif
                                </div>
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

        $('#edit-modal-risk').on('show.bs.modal', function () {
            window.addEventListener('updateChartDataRisk', event => {
                am4core.ready(function () {

                    // Apply chart themes
                    am4core.useTheme(am4themes_animated);

                    let chart = am4core.create("chartRisk", am4charts.XYChart);
                    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                    chart.maskBullets = true;

                    let xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    let yAxis = chart.yAxes.push(new am4charts.CategoryAxis());

                    xAxis.dataFields.category = "x";
                    yAxis.dataFields.category = "y";

                    xAxis.renderer.grid.template.disabled = true;
                    xAxis.renderer.minGridDistance = 40;

                    yAxis.renderer.grid.template.disabled = true;
                    yAxis.renderer.inversed = true;
                    yAxis.renderer.minGridDistance = 30;
                    yAxis.renderer.labels.template.wrap = true;
                    yAxis.renderer.labels.template.maxWidth = 180;


                    let series = chart.series.push(new am4charts.ColumnSeries());
                    series.dataFields.categoryX = "x";
                    series.dataFields.categoryY = "y";
                    series.dataFields.value = "value";
                    series.sequencedInterpolation = true;
                    series.defaultState.transitionDuration = 3000;

                    let column = series.columns.template;
                    column.strokeWidth = 2;
                    column.strokeOpacity = 1;
                    column.stroke = am4core.color("#FFFFFF");
                    column.tooltipText = "Impacto : {impact} \n Probabilidad {probability}";
                    series.tooltip.getFillFromObject = false;
                    series.tooltip.background.fill = am4core.color("#FFFFFF");
                    series.tooltip.label.fill = am4core.color("#000");
                    column.width = am4core.percent(100);
                    column.height = am4core.percent(100);
                    column.column.cornerRadius(6, 6, 6, 6);
                    column.propertyFields.fill = "color";

                    // Set up bullet appearance
                    var bullet1 = series.bullets.push(new am4charts.CircleBullet());
                    bullet1.circle.propertyFields.radius = 'radius';
                    bullet1.circle.fill = am4core.color("#000");
                    bullet1.circle.strokeWidth = 0;
                    bullet1.circle.fillOpacity = 0.7;
                    bullet1.interactionsEnabled = false;
                    series.columns.template.cursorOverStyle = am4core.MouseCursorStyle.pointer;

                    series.columns.template.events.on("hit", function (ev) {
                        let data = ev.target.column.dataItem.dataContext;
                        window.livewire.emitTo('risks.updated-risk', 'updateUrgency', {data: data});
                    }, this);

                    chart.data = event.detail.data;

                });
            })
        })
    </script>
@endpush