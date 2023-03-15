<div class="@if($showPanel) w-25 @else w-auto @endif p-2">
    @if(!$showPanel)
        <a href="javascript:void(0);" class="btn btn-info btn-md btn-icon" wire:click="$set('showPanel',true)">
            <i class="ni ni-menu"></i>
        </a>
    @endif
    @if($showPanel)
        <div class="row">
            <div class="col-6">
                <a href="javascript:void(0)" class="btn btn-sm btn-success waves-effect waves-themed w-80"
                   data-toggle="modal"
                   data-target="#mission-modal">
                    <span class="fal fa-star mr-1"></span>
                    <span>{{trans('general.mission')}}-{{trans('general.vision')}}</span>
                    <span class="fal fa-eye mr-1"></span>
                </a>
            </div>
            <div class="col-6">
                <a href="javascript:void(0)" class="btn btn-info btn-sm btn-pills btn-block waves-effect waves-themed mb-2 w-100"
                   wire:click="$set('showPanel',false)">
                    <span>Ocultar Panel</span>
                </a>
            </div>
        </div>

        <ul id="nav-1" class="nav-menu nav-menu-reset nav-menu-compact nav-menu-bordered mb-sm-4 mb-md-0 rounded js-nav-built"
            data-nav-accordion="true" style="height: auto;" wire:ignore>
            @foreach($arrayTree as $item)
                <li class="open" wire:key="{{time().$item['id']}}" style="background-color: white !important; color: black !important;">
                    <a href="#" style="color: white !important;">
                        @if($modelId==$item['id'])
                            <span class="nav-link-text" style="color: #36848d !important; font-weight: 500 !important;"> {{$item['name']}}</span>
                        @else
                            <span class="nav-link-text color-black"> {{$item['name']}}</span>
                        @endif
                        <span wire:click.prevent="navigateToPlanDetail({{$item['id']}})"
                              class="btn btn-info btn-xs btn-icon rounded-circle mr-1"
                              data-toggle="tooltip" data-placement="top" title="" data-original-title="{{trans('general.show_information_plan_detail')}}">
                         <i class="fal fa-eye"></i>
                     </span>
                    </a>
                    @if(count($item['children']))
                        <ul style="display: block">
                            @include('livewire.strategy.navigation.side-nav-item',['children'=>$item['children']])
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>

@include('modules.strategy.home.mission-vision')

@push('page_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#nav-1").navigationDestroy();

            $("#nav-1").navigation(
                {
                    accordion: $("#nav_accordion").is(':checked') ? true : false,
                    animate: "easeInOutQuad",
                    speed: 400,
                    closedSign: "[+]",
                    openedSign: "[-]",
                });
        });
    </script>

    <script type="text/javascript">
        window.addEventListener('updateNavigation', event => {
            // alert("hola")

            $("#nav-1").navigationDestroy();

            $("#nav-1").navigation(
                {
                    accordion: $("#nav_accordion").is(':checked') ? true : false,
                    animate: "easeInOutQuad",
                    speed: 400,
                    closedSign: "[+]",
                    openedSign: "[-]",
                });
        });
    </script>
@endpush