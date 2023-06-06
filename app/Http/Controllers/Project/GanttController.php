<?php

namespace App\Http\Controllers\Project;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use App\Models\Auth\User;
use App\Models\Projects\Link;
use App\Models\Projects\Activities\Task;
use Illuminate\Http\JsonResponse;

class GanttController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Azure $azure)
    {
        $this->middleware('azure');
        $this->middleware('permission:project-manage|project-super-admin');
    }

    public function get($id, $company = null): JsonResponse
    {
        $task = Task::where('project_id', $id)
            ->when(!is_null($company), function ($q) use ($id, $company) {
                $q->where('type', 'project');
                $q->orWhere(function ($query) use ($id, $company) {
                    $query->where('project_id', $id);
                    $query->where('company_id', $company);
                });
            })
            ->get();

        return response()->json([
            "data" => $task,
            "links" => Link::all(),
        ]);
    }
}
