<div>
    @include('modules.budget.certifications.header-create-certification')
    @include('modules.budget.certifications.poa-create-certification')
    @include('modules.budget.certifications.project-create-certification')
    @if($viewPoaActivity || $viewProjectActivity)
        <div class="d-flex flex-wrap">
            <div class="w-75 mr-2">
                <x-label-section>{{ trans('general.description') }}</x-label-section>
                <div class="content-read-active w-100">
                    <textarea type="text" class="form-control  @error('description') is-invalid @enderror w-100" rows="3" wire:model.defer="description"></textarea>
                </div>
                @error('description')
                <div style="color: #fd3995" class="fs-1x fw-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="ml-auto w-auto">
                <div class="d-flex flex-wrap">
                    <div>
                        <a href="javascript:void(0)" class="btn btn-sm btn-success mr-2"
                           wire:click="saveCertification()">{{trans('general.save')}} {{trans_choice('general.certifications',1)}}
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('budgets.certifications', $transactionPr->id) }}"  class="btn btn-sm btn-outline-secondary">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
