@can('poa-view-all-poas')
    <div class="accordion accordion-clean" id="js_demo_accordion-1a">
        @foreach($companiesArray as $index=>$company)
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="{{'#js_demo_accordion-'.$company['id']}}"
                       aria-expanded="false">
                            <span class="mr-2">
                                <span class="collapsed-reveal">
                                    <i class="fal fa-minus fs-xl"></i>
                                </span>
                                <span class="collapsed-hidden">
                                    <i class="fal fa-plus fs-xl"></i>
                                </span>
                            </span>
                        {{$company['name']}}
                    </a>
                </div>
                <div id="{{'js_demo_accordion-'.$company['id']}}" data-parent="#js_demo_accordion-1a" class="collapse">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover m-0">
                                <thead class="bg-primary-50">
                                <tr>
                                    <th class="w-5 table-th text-info"> {{trans('poa.year')}}</th>
                                    <th class="w-25 table-th text-info">{{trans('poa.name')}}</th>
                                    <th class="w-15 table-th text-info">{{trans('poa.responsible')}}</th>
                                    <th class="w-10 table-th text-info">{{trans('general.phase')}}</th>
                                    <th class="w-10 table-th text-info">{{trans('poa.status')}}</th>
                                    <th class="w-10 table-th text-info">{{trans('poa.reviewed')}}</th>
                                    <th class="w-10 table-th text-info">{{trans('poa.progress')}}</th>
                                    @can('poa-crud-poa'||('poa-view-all-poas'))
                                        <th class="w-15 table-th"><a href="#">{{ trans('general.actions') }}</a></th>
                                    @endcan
                                </tr>
                                </thead>
                            </table>
                        </div>
                        @foreach($companiesChildrenArray as $child)
                            @if($company['id']==$child['parent'])
                                <div class="table-responsive">
                                    <table class="table table-hover m-0">
                                        <tbody>
                                        @foreach($child['poa'] as $poa)
                                            <tr>
                                                <td class="w-5">{{ $poa->year }}</td>
                                                <td class="w-25">{{ $poa->name .' '.'('.$poa->company->name .')' }}</td>
                                                <td class="w-15">{{ $poa->responsible->name }}</td>
                                                <td class="w-10">
                                                    <span class="badge {{ $poa->phase->color() }}">{{ $poa->phase->label() }}</span>
                                                </td>
                                                <td class="w-10">
                                                    <span class="badge {{ $poa->status->color() }} badge-pill">{{ $poa->status->label() }}</span>
                                                </td>
                                                <td class="w-10">
                                                    @if($poa->reviewed)
                                                        <span class="badge badge-success badge-pill">{{ __('general.yes') }}</span>
                                                    @else
                                                        <span class="badge badge-danger badge-pill">{{ __('general.no') }}</span>
                                                    @endif
                                                </td>
                                                <td class="w-10">
                                                    <span class="badge badge-info badge-pill"> {{ number_format($poa->calcProgress(), 0, '.', ',') }} %</span>
                                                </td>
                                                @can('poa-crud-poa')
                                                    <td class="w15">
                                                        <a class="mr-2" href="{{ route('companies.switch', $poa->company->id) }}">
                                                            <i class="fal fa-exchange text-success"></i>
                                                        </a>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endcan