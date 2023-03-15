<div>
    <div class="frame-wrap mb-xl-3">
        <div class="d-flex flex-wrap">
            <div class="mr-2">
                <div class="d-flex w-33 flex-wrap">
                    <div class="btn-group">
                        <a href="{{ route('process.showInformation',  [$process->id, \App\Models\Process\Process::PHASE_PLAN]) }}"
                           class="btn @if($page==\App\Models\Process\Process::PHASE_PLAN) btn-primary @else  btn-secondary @endif mr-2">{{trans('process.plan')}}</a>
                        <a href="{{ route('process.showConformities', [$process->id, \App\Models\Process\Process::PHASE_ACT]) }}"
                           class="btn @if($page==\App\Models\Process\Process::PHASE_ACT) btn-primary @else  btn-secondary @endif mr-2">{{trans('process.act')}}</a>
                        <a href="{{ route('process.showFiles', [$process->id, \App\Models\Process\Process::PHASE_DO_PROCESS]) }}"
                           class="btn @if($page==\App\Models\Process\Process::PHASE_DO_PROCESS) btn-primary @else  btn-secondary @endif mr-2">{{trans('process.do')}}</a>
                        <a href="{{ route('process.showIndicators', [$process->id, \App\Models\Process\Process::PHASE_CHECK]) }}"
                           class="btn @if($page==\App\Models\Process\Process::PHASE_CHECK) btn-primary @else  btn-secondary @endif mr-2">{{trans('process.check')}}</a>
                    </div>
                </div>
            </div>
            <div class="mr-2 mt-2">
                <i class="fal fa-arrow-square-right fa-2x"></i>
            </div>
            <div class="flex-fill" style="width: min-content">
                <div class="d-flex row no-gutters">
                    @switch($page)
                        @case(\App\Models\Process\Process::PHASE_PLAN)
                        @include('livewire.process.plan.menu')
                        @break
                        @case(\App\Models\Process\Process::PHASE_ACT)
                        @include('livewire.process.act.menu')
                        @break
                        @case(\App\Models\Process\Process::PHASE_DO_PROCESS)
                        @include('livewire.process.do.menu')
                        @break
                        @case(\App\Models\Process\Process::PHASE_CHECK)
                        @include('livewire.process.check.menu')
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</div>
