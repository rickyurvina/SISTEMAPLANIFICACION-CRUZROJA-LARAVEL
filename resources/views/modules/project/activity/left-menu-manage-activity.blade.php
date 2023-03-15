<div class="flex-grow-1 w-65" style="overflow: hidden auto">
    <div class="mt-2">
        <x-label-section>{{ trans('general.description') }}</x-label-section>
        <livewire:components.input-text-editor-inline-editor
                :modelId="$task->id"
                class="\App\Models\Projects\Activities\Task"
                field="description"
                :placeholder="trans('general.add_description')"
                :defaultValue="$task->description"/>
    </div>
    <div class="mt-2">
        <div class="demo-v-spacing mt-2">
            <nav class="nav nav-pills" wire:ignore.self>
                @if($project->phase instanceof  \App\States\Project\Planning)
                    <a href="#plan_goals"
                       class="nav-item nav-link btn-xs @if($project->phase instanceof  \App\States\Project\Planning) active @endif"
                       data-toggle="pill" wire:ignore.self>
                        Planificación de Metas
                    </a>
                @endif
                @if($project->phase instanceof  \App\States\Project\Implementation)
                    {{--                                                        <a href="#assigments" class="nav-item nav-link btn-xs"--}}
                    {{--                                                           data-toggle="pill" wire:ignore.self>--}}
                    {{--                                                            Asignaciones--}}
                    {{--                                                        </a>--}}
                    <a href="#progress"
                       class="nav-item nav-link active btn-xs @if($project->phase instanceof  \App\States\Project\Implementation) active @endif"
                       data-toggle="pill" wire:ignore.self>
                        Avance Metas
                    </a>
                    <a href="#work_log" class="nav-item nav-link btn-xs"
                       data-toggle="pill" wire:ignore.self>
                        Registro de Trabajo
                    </a>
                @endif
                <a href="#child_issues" class="nav-item nav-link btn-xs"
                   data-toggle="pill" wire:ignore.self>
                    SubTareas
                </a>
                <a href="#budget" class="nav-item nav-link btn-xs"
                   data-toggle="pill" wire:ignore.self>
                    Partidas Presupuestarias
                </a>
                <a href="#files" class="nav-item nav-link btn-xs" data-toggle="pill"
                   wire:ignore.self>
                    Adjuntos y Comentarios
                </a>
            </nav>
            <div class="tab-content py-3" wire:ignore.self>
                <div class="tab-pane fade show @if($project->phase instanceof  \App\States\Project\Planning) active @endif"
                     id="plan_goals"
                     role="tabpanel" wire:ignore.self>
                    @include('modules.project.activity.plan_goals')
                </div>
                <div class="tab-pane fade show @if($project->phase instanceof  \App\States\Project\Implementation) active @endif"
                     id="progress"
                     role="tabpanel" wire:ignore.self>
                    @include('modules.project.activity.advances')
                </div>
                <div class="tab-pane fade show" id="work_log" role="tabpanel"
                     wire:ignore.self>
                    @include('modules.project.activity.work_log')
                </div>
                <div class="tab-pane fade show" id="child_issues" role="tabpanel" wire:ignore.self>
                    @include('modules.project.activity.child_issues')
                </div>
                <div class="tab-pane fade show" id="budget" role="tabpanel" wire:ignore>
                    @include('modules.project.activity.budget')
                </div>
                <div class="tab-pane fade show" id="files" role="tabpanel"
                     wire:ignore.self>
                    @include('modules.project.activity.files')
                </div>
            </div>
        </div>
    </div>
</div>