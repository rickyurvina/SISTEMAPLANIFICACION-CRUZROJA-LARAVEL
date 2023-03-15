<div class="d-flex flex-wrap p-2 mb-3">
    <div class="w-25">
        <a href="javascript:void(0)" wire:click="$set('viewPoa', true)" class="btn btn-outline-success">{{ trans('general.poa') }}</a>
        <a href="javascript:void(0)" wire:click="$set('viewProject', true)" class="btn btn-outline-success">{{ trans_choice('general.project',2) }}</a>
    </div>
    <div class="w-75">
        <div class="input-group bg-white shadow-inset-2 w-25 mr-2">
            <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                   placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.activities', 2) }} ..."
                   wire:model="search">
            <div class="input-group-append">
                <span class="input-group-text bg-transparent border-left-0">
                    <i class="fal fa-search"></i>
                </span>
            </div>
        </div>
    </div>
</div>