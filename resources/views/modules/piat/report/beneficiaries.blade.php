<div>
    <div class="d-flex flex-wrap">
        <div class="p-2">
            <x-label-section>{{ trans('poa.piat_matrix_report_divider_beneficiaries') }}
            </x-label-section>
        </div>
        <div class="p-2">
            <div class="d-flex w-100">
                <div class="detail">
                    <select class="form-control" id="example-select"
                            wire:model="period">
                        <option value="">Escoger Periodo</option>
                        @foreach($goals as $goal)
                            <option value="{{$goal['id']}}">{{$goal['period']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="section-divider"></div>
    <div class="d-flex flex-wrap align-items-center justify-content-between mr-2">
        <div class="form-group w-30 pr-1">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_men') }}:
            </x-label-section>
            <span aria-hidden="true">{{ $contMen }}</span>
        </div>
        <div class="form-group w-30">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_women') }}:
            </x-label-section>
            <span aria-hidden="true">{{ $contWomen }}</span>
        </div>
        <div class="form-group w-30">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_total') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $contMen + $contWomen }}</span>
        </div>
        <div class="form-group"></div>
    </div>
    <x-label-section>
        {{ trans('poa.piat_matrix_report_divider_beneficiaries_disabilities') }}
    </x-label-section>
    <div class="section-divider"></div>
    <div class="d-flex flex-wrap align-items-center justify-content-between mr-2">
        <div class="form-group w-30 pr-1">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_disabilities_yes') }}:
            </x-label-section>
            <span aria-hidden="true" style="color: red; font-weight: bold;">
                @if ($contDisability > 0)
                    X
                @endif
            </span>
        </div>
        <div class="form-group w-30">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_disabilities_total') }}:
            </x-label-section>
            <span aria-hidden="true">
                                        @if ($contDisability > 0)
                    {{ $contDisability }}
                @endif
                                    </span>
        </div>
        <div class="form-group w-30">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_disabilities_no') }}:
            </x-label-section>
            <span aria-hidden="true" style="color: red; font-weight: bold;">
                                        @if ($contDisability < 1)
                    X
                @endif
                                    </span>
        </div>
        <div class="form-group"></div>
    </div>
    <x-label-section>
        {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group') }}
    </x-label-section>
    <div class="section-divider"></div>
    <div class="d-flex flex-wrap align-items-center justify-content-between mr-2">
        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_under_6') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $under6 }}</span>
        </div>
        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_between_6_12') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $btw6And12 }}</span>
        </div>
        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_between_13_17') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $btw13And17 }}</span>
        </div>

        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_between_18_29') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $btw18And29 }}</span>
        </div>
        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_between_30_39') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $btw30And39 }}</span>
        </div>
        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_between_40_49') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $btw40And49 }}</span>
        </div>
        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_between_50_59') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $btw50And59 }}</span>
        </div>
        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_between_60_69') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $btw60And69 }}</span>
        </div>
        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_between_70_79') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $btw70And79 }}</span>
        </div>

        <div class="form-group w-10">
            <x-label-section>
                {{ trans('poa.piat_matrix_report_divider_beneficiaries_age_group_greater_than_80') }}:
            </x-label-section>
            <span aria-hidden="true"
                  style="color: red; font-weight: bold;">{{ $greaterThan80 }}</span>
        </div>
        <div class="form-group"></div>
    </div>
    @if($period)
        <form method="post" enctype='multipart/form-data' wire:submit.prevent="getCsvFile()"
              id="upload-file">
            <div class="row">
                <div class="form-group col-12 pl-6 pt-4">
                    <x-fileupload wire:model.defer="file" allowRevert allowRemove
                                  allowFileSizeValidation maxFileSize="4mb"></x-fileupload>
                    @error('file')
                    <div class="alert alert-danger fade show" role="alert">
                        {{ __('general.file_required') }}
                    </div>
                    @enderror
                </div>
                <div class="col-12" wire:loading wire:target="getCsvFile">
                    <div class="demo">
                        <button class="btn btn-danger rounded-pill waves-effect waves-themed ml-auto" type="button" disabled="">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Subiendo información...No cierre esta ventana mientras se carga el archivo...
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <x-form.modal.footer data-dismiss="modal"></x-form.modal.footer>
            </div>
        </form>
    @else
        <x-empty-content>
            <x-slot name="title">
                Seleccionar periodo para registrar los avances.
            </x-slot>
        </x-empty-content>
    @endif

</div>
