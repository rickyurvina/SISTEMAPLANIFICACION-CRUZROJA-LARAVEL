@foreach($children as $child)
    @if($loop->first)
        <li>
            <a href="javascript:void(0)" class="text-uppercase text-center"
               style="color: white !important; display: block !important; font-weight: 800">
                <span class="fw-700 color-black"> {{$child['objective_name']}}</span>
                <strong class="dl-ref bg-success-600">&nbsp;{{count($child['children'])}}&nbsp;</strong>
            </a>
        </li>
    @endif
    <li wire:key="{{time().$child['id']}}" wire:ignore style="background-color: white !important; color: black !important;">
        <a href="#" style="color: white !important;">
        @if($modelId==$child['id'])
                <span class="nav-link-text" style="color: #36848d !important; font-weight: 500 !important;"> {{$child['name']}}</span>
            @else
                <span class="nav-link-text color-black"> {{$child['name']}}</span>
            @endif
            <span wire:click="navigateToPlanDetail({{$child['id']}})"
                  class="btn btn-info btn-xs btn-icon rounded-circle mr-1"
                  data-toggle="tooltip" data-placement="top" title="" data-original-title="{{trans('general.show_information_plan_detail')}}">
              <i class="fal fa-eye"></i>
            </span>
        </a>
        <ul>
            @include('livewire.strategy.navigation.side-nav-item',['children'=>$child['children']])
        </ul>
    </li>
@endforeach