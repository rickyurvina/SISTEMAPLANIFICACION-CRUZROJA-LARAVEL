<?php

namespace App\Http\Controllers\Common;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use App\Jobs\Admin\AttachPermissionByAction;
use App\Traits\Jobs;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $azure;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Azure $azure)
    {
        $this->azure = $azure;
        $this->middleware('azure');
        $this->middleware('auth', ['only' => 'index']);
        $this->middleware('permission:strategy-view|strategy-manage|
        project-view|project-manage|
        budget-view|budget-manage|
        poa-view|poa-manage|
        administrative-view|administrative-manage|
        process-view|process-manage|
        admin-view|admin-manage|
        audit-view|audit-manage', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return|View
     */
    public function index()
    {
        return view('common.home.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return|View
     */
    public function verifyAzureUser(Request $request)
    {
        $data = json_decode(session('data_azure'));
        return $this->azure->success($request, session('_azure_access_token'), session('_azure_refresh_token'), $data);
    }

    public function portal($data)
    {
        return view('auth.app');
    }
}
