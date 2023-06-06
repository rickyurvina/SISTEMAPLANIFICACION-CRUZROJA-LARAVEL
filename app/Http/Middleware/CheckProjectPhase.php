<?php

namespace App\Http\Middleware;

use App\Models\Projects\Project;
use App\States\Project\Closed;
use App\States\Project\Implementation;
use App\States\Project\Planning;
use App\States\Project\StartUp;
use Closure;
use Illuminate\Http\Request;

class CheckProjectPhase
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $project = $request->route('project');
        if ($project) {
            $currentPhase = $project->phase;

            if ($currentPhase instanceof StartUp && (
                    $request->routeIs('projects.team') ||
                    $request->routeIs('projects.activities') ||
                    $request->routeIs('projects.activities_results') ||
                    $request->routeIs('projects.activities_resultsInternal') ||
                    $request->routeIs('projects.calendar') ||
                    $request->routeIs('projects.acquisitions') ||
                    $request->routeIs('projects.communication') ||
                    $request->routeIs('projects.budgetDocumentReport') ||
                    $request->routeIs('projectsInternal.budgetDocumentReport')
                )) {
                abort(403, 'No puedes acceder a las funciones de planificación mientras el proyecto está en la fase de inicio');
            }

            if (($currentPhase instanceof Planning || $currentPhase instanceof Implementation || $currentPhase instanceof Closed) &&
                (
                    $request->routeIs('projects.showIndex') ||
                    $request->routeIs('projects.doc') ||
                    $request->routeIs('projects.showReferentialBudget') ||
                    $request->routeIs('projects.showReferentialBudgetInternal')
                )) {
                abort(403, 'No puedes acceder a las funciones de ejecución o inicio mientras el proyecto está en la fase de planificación');
            }

            if (($currentPhase instanceof Implementation) &&
                (
                $request->routeIs('projects.team')
                )) {
                abort(403, 'No puedes acceder a las funciones de ejecución o inicio mientras el proyecto está en la fase de planificación');
            }
        }


        return $next($request);
    }
}
