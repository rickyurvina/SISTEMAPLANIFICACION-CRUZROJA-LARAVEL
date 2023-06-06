<?php

namespace App\Http\Controllers\Project;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use App\Models\Projects\Link;
use App\Models\Projects\Project;
use App\Models\Projects\Activities\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
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


    public function store(Request $request, Project $project): JsonResponse
    {
        $link = new Link();

        $link->type = $request->type;
        $link->source = $request->source;
        $link->target = $request->target;

        $link->save();

        return response()->json([
            "action" => 'inserted',
            "tid" => $link->id,
            "method"=>'link',
        ]);
    }

    public function update(Request $request, Project $project, Link $link): JsonResponse
    {
        $link->type = $request->type;
        $link->source = $request->source;
        $link->target = $request->target;

        $link->save();
        return response()->json([
            "action" => 'updated',
            "method"=>'link',
        ]);
    }

    public function delete(Project $project, Link $link): JsonResponse
    {
        $link->delete();
        return response()->json([
            "action" => 'deleted',
            "method"=>'link',
        ]);
    }
}
