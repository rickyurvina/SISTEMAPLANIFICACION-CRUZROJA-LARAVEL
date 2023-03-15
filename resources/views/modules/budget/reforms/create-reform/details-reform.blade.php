<div class="d-flex flex-wrap mt-2 p-2">
    <h2><i class="fa fa-money-bill text-success"></i> Detalles de la reforma</h2>
    <hr>
    <div class="w-100 pl-2">
        <div class="table-responsive">
            <table class="table table-light">
                @include('modules.budget.reforms.create-reform.header-table-details')
                <tbody>
                @include('modules.budget.reforms.create-reform.body-table-array-reforms-incomes')
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-light">
                <tbody>
                <tr class="text-center border-top border-bottom bg-secondary color-white">
                    <td colspan="4"> Gastos</td>
                </tr>
                @include('modules.budget.reforms.create-reform.body-table-array-reforms-expenses')
                <tr style="background-color: #e0e0e0">
                    <td colspan="4" class="fs-2x fw-700 text-center @if($totalDecreases==$totalIncrements) color-success-700 @else color-danger-700 @endif">
                        Balance {{money( $totalDecreases*100)}}*****{{money( $totalIncrements*100)}}
                    </td>
                </tr>
                @error('newValue')
                <tr>
                    <td colspan="4" class="text-center">
                        <span class="badge badge-danger text-center">{{ $message }}</span>
                    </td>
                </tr>
                @enderror
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-center">
    <a  href="{{ route('budgets.reforms', $transaction->id) }}"  class="btn btn-outline-secondary" >
        <i class="fas fa-times"></i> {{ trans('general.cancel') }}
    </a>
    <button class="btn btn-success text-center" wire:click="saveReform">
        <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
    </button>
</div>