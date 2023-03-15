@can('view-indicators-process'||'manage-indicators-process')
    <a href="{{ route('process.showIndicators', [$process->id, $page]) }}"
       class="btn {{ $subMenu == 'showIndicators' ? 'btn-success':' btn-info' }} mr-2"
    >
                        <span
                              data-placement="top" title="Indicadores"
                              data-original-title="Indicadores">
                    <i class="fas fa-arrow-alt-square-up  mr-1"></i>{{trans_choice('general.indicators',2)}}</span>
    </a>
@endcan