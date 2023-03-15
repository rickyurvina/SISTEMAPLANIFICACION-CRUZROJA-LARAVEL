@extends('layouts.admin')

@section('title', __('poa.list_poas').trans_choice('general.thresholds',2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-sort-circle text-primary"></i> {{ __('general.thresholds') }}
    </h1>

@endsection

@section('content')
    @if($poas)
        <div class="table-responsive">
            <table class="table table-hover m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th class="w-25 table-th text-info">{{trans('general.company')}}</th>
                    <th class="w-25 table-th text-info">{{trans('poa.name')}}</th>
                    <th class="w-15 table-th text-info">{{trans('poa.responsible')}}</th>
                    <th class="w-10 table-th text-info">{{trans('general.phase')}}</th>
                    <th class="w-10 table-th text-info">{{trans('poa.status')}}</th>
                    <th class="w-10 table-th text-info">{{trans('general.min')}}</th>
                    <th class="w-10 table-th text-info">{{trans('general.max')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($poas as $item)
                    <tr>
                        <td>{{ $item->company->name }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->responsible->name }}</td>
                        <td>
                            <span class="badge {{ $item->phase->color() }}">{{ $item->phase->label() }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $item->status->color() }} badge-pill">{{ $item->status->label() }}</span>
                        </td>
                        <td>
                            <livewire:components.input-inline-edit :modelId="$item->id"
                                                                   class="{{\App\Models\Poa\Poa::class}}"
                                                                   field="min"
                                                                   type="number"
                                                                   globalScopes="true"
                                                                   :rules="'required|integer|min:0|max:'.$item->max-1"
                                                                   defaultValue="{{$item->min }}"
                                                                   :key="time().$item->id"
                            />
                        </td>
                        <td>
                            <livewire:components.input-inline-edit :modelId="$item->id"
                                                                   class="{{\App\Models\Poa\Poa::class}}"
                                                                   field="max"
                                                                   type="number"
                                                                   globalScopes="true"
                                                                   :rules="'required|integer|max:100|min:'.$item->min+1"
                                                                   defaultValue="{{$item->max}}"
                                                                   :key="time().$item->id"
                            />
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            <x-pagination :items="$poas"/>
        </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                {{trans('general.there_are_no_poas')}}
            </x-slot>
        </x-empty-content>
    @endif
@endsection