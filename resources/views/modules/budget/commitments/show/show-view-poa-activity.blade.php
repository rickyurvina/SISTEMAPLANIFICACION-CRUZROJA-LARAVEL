@if($viewPoaActivity)
    <div class="d-flex mt-2">
        <div class="w-50">
            <table class="table table-bordered detail-table">
                <tbody>
                <tr>
                    <td class="fs-1x fw-700 w-20">Ejercicio</td>
                    <td colspan="2">
                        {{$transaction->year}}</td>
                </tr>
                <tr>
                    <td class="fs-1x fw-700">Poa</td>
                    <td class="w-5">
                        {{$poaActivity->program->poa->year}}
                    </td>
                    <td class="fs-1x fw-700">
                        {{$poaActivity->program->poa->name}}
                    </td>
                </tr>
                <tr>
                    <td class="fs-1x fw-700">{{trans_choice('general.plan',1)}}</td>
                    <td>
                        {{$poaActivity->program->planDetail->plan->code}}
                    </td>
                    <td class="fs-1x fw-700">
                        {{$poaActivity->program->planDetail->plan->name}}
                    </td>
                </tr>
                <tr>
                    <td class="fs-1x fw-700 w-20">{{$poaActivity->program->planDetail->parent->parent->planRegistered->name}}
                    </td>
                    <td class="w-5">{{$poaActivity->program->planDetail->parent->parent->code}}</td>
                    <td class="fs-1x fw-700">{{$poaActivity->program->planDetail->parent->parent->name}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="w-50">
            <table class="table table-bordered detail-table">
                <tbody>

                <tr>
                    <td class="fs-1x fw-700 w-20">{{$poaActivity->program->planDetail->parent->planRegistered->name}}
                    </td>
                    <td class="w-5">{{$poaActivity->program->planDetail->parent->code}}</td>
                    <td class="fs-1x fw-700">{{$poaActivity->program->planDetail->parent->name}}</td>
                </tr>
                <tr>
                    <td class="fs-1x fw-700">{{trans_choice('general.programs',1)}}</td>
                    <td>
                        {{$poaActivity->program->planDetail->code}}
                    </td>
                    <td class="fs-1x fw-700">
                        {{$poaActivity->program->planDetail->name}}
                    </td>
                </tr>
                <tr>
                    <td class="fs-1x fw-700 w-20">Indicador
                    </td>
                    <td class="w-5">{{$poaActivity->indicator->code}}</td>
                    <td class="fs-1x fw-700">{{$poaActivity->indicator->name}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if($expensesPoa->count()>0)
        @include('modules.budget.commitments.show.table-show',['accounts'=>$expensesPoa])
    @endif
@endif
