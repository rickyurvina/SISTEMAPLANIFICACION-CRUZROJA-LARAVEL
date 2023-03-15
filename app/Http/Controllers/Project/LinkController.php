<?php

namespace App\Http\Controllers\Project;

use App\Abstracts\Http\Controller;
use App\Models\Projects\Link;
use App\Models\Projects\Project;
use App\Models\Projects\Activities\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
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
