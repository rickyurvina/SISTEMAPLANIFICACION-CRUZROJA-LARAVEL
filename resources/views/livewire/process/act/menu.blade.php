@can('view-conformities-process'||'manage-conformities-process'||'close-conformities-process')
    <a href="{{ route('process.showConformities',[$process->id, $page]) }}"
       class="btn {{ $subMenu == 'showConformities' ? 'btn-success':' btn-info' }} mr-2"
    >
                <span
                      data-placement="top" title="No Conformidades"
                      data-original-title="No Conformidades">
                     <i class="fas fa-align-slash  mr-1"></i>{{__('general.nonconformities')}}</span>
    </a>
@endcan