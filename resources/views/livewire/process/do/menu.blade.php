@can('view-files-process-process'||'manage-files-process-process')
    <a href="{{ route('process.showFiles', [$process->id, $page]) }}"
       class="btn  {{ $subMenu == 'showFiles' ? 'btn-success':' btn-info' }} mr-2"
    >
                        <span
                              data-placement="top" title="Archivos"
                              data-original-title="Archivos">
                    <i class="fas fa-paperclip  mr-1"></i>{{__('general.files')}}</span>
    </a>
@endcan