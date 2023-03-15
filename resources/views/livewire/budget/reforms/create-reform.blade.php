<div>
    @include('modules.budget.reforms.create-reform.header')
    <div class="row">
        <div class="col-6 p-2">
            <div class="d-flex flex-wrap p-2 mt-2">
                <h2><i class="fa fa-search text-success"></i> Buscar Partidas Presupuestarias</h2>
            </div>
            <div class="d-flex flex-wrap mt-1">
                <div class="frame-wrap">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="incomes" name="inlineDefaultRadiosExample"
                               wire:click="$set('typeBudgetIncome', true)" checked="">
                        <label class="custom-control-label" for="incomes">{{trans('budget.incomes')}}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="expenses" name="inlineDefaultRadiosExample"
                               wire:click="$set('typeBudgetExpense', true)">
                        <label class="custom-control-label" for="expenses">{{trans('budget.expense')}}</label>
                    </div>
                </div>
            </div>
            @include('modules.budget.reforms.create-reform.list-accounts')
        </div>
        <div class="col-6 p-2">
            @if($account)
                @include('modules.budget.reforms.create-reform.header-details')
                @include('modules.budget.reforms.create-reform.details-reform')
            @endif
        </div>
    </div>
</div>

@push('page_script')
    <script>
        $(document).ready(function () {
            $('#select2-types-reforms').select2({
                placeholder: "{{ trans('general.select').' '.trans_choice('general.state',2) }}"
            }).on('change', function (e) {
                @this.
                set('typeReformSelected', $(this).val());
            });
        });
        $('#select2-registers').select2({
            placeholder: "{{ trans('general.select').' '.trans_choice('general.state',2) }}"
        }).on('change', function (e) {
            @this.
            set('countRegisterSelect', $(this).val());
        });
    </script>
@endpush