@extends('modules.projectInternal.project')

@push('stylesheet')
    <link href='fullcalendar/main.css' rel='stylesheet'/>
@endpush

@push('script')
    <script src='fullcalendar/main.js'></script>
@endpush

@section('project-page')
    <div class="p-2 m-4">
        <div id="calendar" class="w-100 p-2">
        </div>
    </div>
    <div wire:ignore>
        <livewire:projects.activities.project-register-advance-activity />
    </div>
    <div wire:ignore>
        <livewire:projects.logic-frame.project-create-result-activity :project="$project" />
    </div>
@endsection

@push('page_script')
    <script>
        Livewire.on('toggleRegisterAdvanceActivity', () => $('#register-advance-activity').modal('toggle'));
        Livewire.on('toggleCreateActivity', () => $('#project-create-result-activity').modal('toggle'));
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                displayEventTime: false,
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events:@json($data),
                dateClick: function (info) {
                    let date=info.dateStr;
                    window.livewire.emitTo('projects.logic-frame.project-create-result-activity','openCreateModal',{date:date, internal:true});
                },
                eventClick: function (calEvent, jsEvent, view) {
                    let id=calEvent.event.id;
                    window.livewire.emitTo('projects.activities.project-register-advance-activity', 'openAdvance', {id: id, isCalendar: true, internal: true});
                },
            });

            calendar.render();
        });
    </script>
@endpush
