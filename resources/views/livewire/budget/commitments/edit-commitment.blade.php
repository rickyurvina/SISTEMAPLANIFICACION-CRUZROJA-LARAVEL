<div>
    @if($viewPoaActivity)
        <div class="d-flex mt-2">
            <div class="w-50">
                <table class="table table-bordered detail-table">
                    <tbody>
                    <tr>
                        <td class="fs-1x fw-700 w-20">Ejercicio</td>
                        <td colspan="2">
                            {{$commitment->year}}</td>
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
                    </tbody>
                </table>
            </div>
            <div class="w-50">
                <table class="table table-bordered detail-table">
                    <tbody>
                    <tr>
                        <td class="fs-1x fw-700 w-20">{{$poaActivity->program->planDetail->parent->parent->planRegistered->name}}
                        </td>
                        <td class="w-5">{{$poaActivity->program->planDetail->parent->parent->code}}</td>
                        <td class="fs-1x fw-700">{{$poaActivity->program->planDetail->parent->parent->name}}</td>
                    </tr>
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
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                    <tr>
                        <th class="table-th w-20">{{trans('general.item')}}</th>
                        <th class="table-th w-20"> {{trans('general.name')}}</th>
                        <th class="table-th w-30"> {{trans('general.description')}}</th>
                        <th class="table-th w-10">Certificado</th>
                        <th class="table-th w-10"><a href="#">Comprometido</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expensesPoa as $item)
                        <tr class="tr-hover">
                            <td><span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }} {{$item->name}}</span></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->getCertifiedValues($certification->id) }} </td>
                            <td>
                                <div class="w-100 content-read-active">
                                    <input class="w-100 border-0 fw-400" type="number" wire:model.lazy="commitmentsValues.{{$item->id}}">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    @if($viewProjectActivity)
        <div class="d-flex mt-2">
            <div class="w-50">
                <table class="table table-bordered detail-table">
                    <tbody>
                    <tr>
                        <td class="fs-1x fw-700 w-20">Ejercicio</td>
                        <td colspan="2">
                            {{$commitment->year}}</td>
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
        @if($expensesProject)
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                    <tr>
                        <th class="table-th w-20">{{trans('general.item')}}</th>
                        <th class="table-th w-20"> {{trans('general.name')}}</th>
                        <th class="table-th w-30"> {{trans('general.description')}}</th>
                        <th class="table-th w-10">Certificado</th>
                        <th class="table-th w-10"><a href="#">Comprometido</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expensesProject as $item)
                        <tr class="tr-hover">
                            <td><span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }} {{$item->name}}</span></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->getCertifiedValues($certification->id) }} </td>
                            <td>
                                <div class="w-100 content-read-active">
                                    <input class="w-100 border-0 fw-400" type="number" wire:model.lazy="commitmentsValues.{{$item->id}}">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

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
                           wire:click="saveCommitment()">{{trans('general.update')}} {{trans_choice('general.commitments',1)}}
                        </a>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="btn btn-sm btn-outline-secondary" wire:click="closeActivity()">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
