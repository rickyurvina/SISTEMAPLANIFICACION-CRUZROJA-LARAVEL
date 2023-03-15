<form wire:submit.prevent="submitAgreementsCommitments()" method="post" autocomplete="off">
    <x-label-section>
        {{ trans('poa.piat_matrix_report_divider_agreement_commitment') }}
    </x-label-section>
    <div class="section-divider"></div>
    <div class="d-flex flex-wrap">
        <div class="form-group w-75 pr-1">
            <label class="form-label fw-700"
                   for="agreCommDescription">{{ trans('poa.piat_matrix_report_divider_agreement_commitment') }}
            </label>
            <input type="text" id="agreCommDescription" class="form-control @error('agreCommDescription') is-invalid @enderror"
                   placeholder="{{ trans('poa.piat_matrix_report_divider_agreement_commitment') }}"
                   wire:model.defer="agreCommDescription">
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('agreCommDescription') }}</div>

        </div>
        <div class="form-group w-20">
            <label class="form-label fw-700"
                   for="agreCommResponsable">{{ trans('poa.piat_matrix_create_placeholder_responsable') }}</label>
            <select wire:model.defer="agreCommResponsable"
                    class="custom-select bg-transparent  @error('agreCommResponsable') is-invalid @enderror">
                <option value="" selected>
                    {{ trans('poa.piat_matrix_create_placeholder_responsable') }}
                </option>
                @foreach ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('agreCommResponsable') }}</div>
        </div>
        <div class="w-5">
            <button class="ml-2 mt-4"
                    wire:click.prevent="submitAgreementsCommitments"
                    style="border: 0 !important; background-color: transparent !important">
                <i class="fas fa-plus mr-1 text-success"></i>
            </button>
        </div>
    </div>
</form>
@if($piatReportAgreComm && $piatReportAgreComm->count()>0)
    @foreach($piatReportAgreComm as $item)
        <div class="d-flex flex-wrap mr-2" wire:key="{{time().$item->id}}" wire:ignore>
            <div class="w-75 pr-1">
                <livewire:components.input-inline-edit :modelId="$item->id"
                                                       class="{{\App\Models\Poa\Piat\PoaMatrixReportAgreementCommitment::class}}"
                                                       field="description"
                                                       :rules="'required|max:200'"
                                                       type="text"
                                                       defaultValue="{{ $item->description ?? ''}}"
                                                       :key="time().$item->id"/>
            </div>
            <div class="w-20">
                <livewire:components.select-inline-edit :modelId="$item->id"
                                                        :fieldId="$item->responsable"
                                                        class="{{\App\Models\Poa\Piat\PoaMatrixReportAgreementCommitment::class}}"
                                                        field="responsable"
                                                        value="{{$item->userResponsable ? $item->userResponsable->getFullName() :''}}"
                                                        :selectClass="$users"
                                                        selectField="name"
                                                        selectRelation="userResponsable"
                                                        :key="time().$item->id"/>
            </div>
            <div class="w-5">
                <button class="ml-2 mt-2"
                        wire:click.prevent="deleteAgreementsCommitments({{ $item->id }})"
                        style="border: 0 !important; background-color: transparent !important;">
                    <i class="fas fa-trash mr-1 text-danger"></i>
                </button>
            </div>
        </div>
    @endforeach
@endif