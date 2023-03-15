@if($viewProjectActivity)
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
                    <td class="fs-1x fw-700">Proyecto</td>
                    <td class="w-5">
                        {{$projectActivity->project->code}}
                    </td>
                    <td class="fs-1x fw-700">
                        {{$projectActivity->project->name}}
                    </td>
                </tr>

                <tr>
                    <td class="fs-1x fw-700">Junta Ejecutora</td>
                    <td>
                        {{$projectActivity->company->id}}
                    </td>
                    <td class="fs-1x fw-700">
                        {{$projectActivity->company->name}}
                    </td>
                </tr>
                <tr>
                    <td class="fs-1x fw-700 w-20">{{trans_choice('general.indicators',1)}}
                    </td>
                    <td class="w-5">{{$projectActivity->indicator->code ?? ''}}</td>
                    <td class="fs-1x fw-700">{{$projectActivity->indicator->name ?? 'Sin Indicador Asociado'}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="w-50">
            <table class="table table-bordered detail-table">
                <tbody>
                <tr>
                    <td class="fs-1x fw-700 w-20">{{trans('general.specific_objective')}}
                    </td>
                    <td class="w-5">{{$projectActivity->parentOfTask->objective->code ?? ''}}</td>
                    <td class="fs-1x fw-700">{{$projectActivity->parentOfTask->objective->name ?? ''}}</td>
                </tr>
                <tr>
                    <td class="fs-1x fw-700 w-20">{{trans('general.result')}}
                    </td>
                    <td class="w-5">{{$projectActivity->parentOfTask->code}}</td>
                    <td class="fs-1x fw-700">{{$projectActivity->parentOfTask->text}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if($expensesProject->count()>0)
        @include('modules.budget.commitments.create.table-create-form',['accounts'=>$expensesProject])
    @endif
@endif