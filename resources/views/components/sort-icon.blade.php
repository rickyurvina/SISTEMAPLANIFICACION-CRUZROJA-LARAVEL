@if($sortField==$field)
    @switch($sortDirection )
        @case('asc')
        <i class="fal fa-sort-down ml-1"></i>
        @break
        @case('desc')
        <i class="fal fa-sort-up ml-1"></i>
        @break
    @endswitch
@else
    <i class="fal fa-sort ml-1"></i>
@endif