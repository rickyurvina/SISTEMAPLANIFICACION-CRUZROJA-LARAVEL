<div class="col-12">
    <div class="text-center py-3">
        <strong>{{trans('general.personal_information')}}</strong>
    </div>
    <a href="javascript:void(0);" class="d-flex flex-row align-items-center mb-1">
        <div class='icon-stack display-4 flex-shrink-0'>
            <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
            <i class="fas fa-mail-bulk icon-stack-1x opacity-100 color-primary-500"></i>
        </div>
        <div class="ml-3">
            <strong style="color: black">
                {{$user->email}}
            </strong>
        </div>
    </a>
    <a href="javascript:void(0);" class="d-flex flex-row align-items-center mb-1">
        <div class='icon-stack display-4 flex-shrink-0'>
            <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
            <i class="fas fa-phone-plus icon-stack-1x opacity-100 color-primary-500"></i>
        </div>
        <div class="ml-3">
            <strong style="color: black">
                {{$user->personal_phone}}
            </strong>
        </div>
    </a>
    <a href="javascript:void(0);" class="d-flex flex-row align-items-center mb-1">
        <div class='icon-stack display-4 flex-shrink-0'>
            <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
            <i class="fas fa-calendar-check icon-stack-1x opacity-100 color-primary-500"></i>
        </div>
        <div class="ml-3">
            <strong style="color: black">
                {{$user->date_birth }}
            </strong>
        </div>
    </a>
    <div class="panel-container show">
        <div class="collapse" id="collapseExample">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#user-show-work-experience"
               data-id="{{$user->id}}" class="d-flex flex-row align-items-center mb-1">
                <div class='icon-stack display-4 flex-shrink-0'>
                    <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                    <i class="fas fa-chart-network icon-stack-1x opacity-100 color-primary-500"></i>
                </div>
                <div class="ml-3">
                    <strong style="color: black">
                        Experiencia Laboral
                    </strong>
                </div>
            </a>
            <a href="javascript:void(0);" class="d-flex flex-row align-items-center mb-1">

                <div class='icon-stack display-4 flex-shrink-0'>
                    <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                    <i class="fas fa-graduation-cap icon-stack-1x opacity-100 color-primary-500"></i>
                </div>
                <div class="ml-3">
                    <strong style="color: black">
                        {{$user->job_title}}
                    </strong>
                </div>
            </a>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#user-show-competencies"
               data-id="{{$user->id}}" class="d-flex flex-row align-items-center mb-1">
                <div class='icon-stack display-4 flex-shrink-0'>
                    <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                    <i class="fas fa-handshake icon-stack-1x opacity-100 color-primary-500"></i>
                </div>
                <div class="ml-3">
                    <strong style="color: black">
                        {{trans('general.competencies')}}
                    </strong>
                </div>
            </a>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#user-show-skills"
               data-id="{{$user->id}}" class="d-flex flex-row align-items-center mb-1">
                <div class='icon-stack display-4 flex-shrink-0'>
                    <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                    <i class="fas fa-hands-helping icon-stack-1x opacity-100 color-primary-500"></i>
                </div>
                <div class="ml-3">
                    <strong style="color: black">
                        {{trans('general.working_skills')}}
                    </strong>
                </div>
            </a>
            <a href="javascript:void(0);" class="d-flex flex-row align-items-center mb-1">
                <div class='icon-stack display-4 flex-shrink-0'>
                    <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                    <i class="fas fa-money-bill icon-stack-1x opacity-100 color-primary-500"></i>
                </div>
                <div class="ml-3">
                    <strong style="color: black">
                        Costo contrato: ${{$user->employer_cost}}
                    </strong>
                </div>
            </a>
            <a href="javascript:void(0);" class="d-flex flex-row align-items-center mb-1">
                <div class='icon-stack display-4 flex-shrink-0'>
                    <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                    <i class="fas fa-money-check icon-stack-1x opacity-100 color-primary-500"></i>
                </div>
                <div class="ml-3">
                    <strong style="color: black">
                        Contrato:  {{$user->contract_type}} Fecha Inicio/Fin:{{$user->contract_start}}- {{$user->contract_end}}

                    </strong>
                </div>
            </a>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#user-show-files"
               data-id="{{$user->id}}" class="d-flex flex-row align-items-center mb-1">
                <div class='icon-stack display-4 flex-shrink-0'>
                    <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                    <i class="fas fa-file icon-stack-1x opacity-100 color-primary-500"></i>
                </div>
                <div class="ml-3">
                    <strong style="color: black">
                        {{trans('general.files')}}
                    </strong>
                </div>
            </a>
        </div>
        <div class="col-12">
            <div class="p-3 text-center">
                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"
                   class="btn-link font-weight-bold">{{trans('general.see_more')}}</a>
            </div>
        </div>
    </div>
</div>