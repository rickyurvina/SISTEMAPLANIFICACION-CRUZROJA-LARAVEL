<?php

namespace App\Http\Controllers\Process\Catalogs;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use App\Http\Requests\StoreGeneratedServiceRequest;
use App\Http\Requests\UpdateGeneratedServiceRequest;
use App\Jobs\Process\Catalogs\GeneratedServices\CreateGeneratedService;
use App\Jobs\Process\Catalogs\GeneratedServices\DeleteGeneratedService;
use App\Jobs\Process\Catalogs\GeneratedServices\UpdateGeneratedService;
use App\Models\Process\Catalogs\GeneratedService;
use Illuminate\Http\Request;

class GeneratedServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Azure $azure)
    {
        $this->middleware('azure');
        $this->middleware('permission:process-manage');
        $this->middleware('permission:process-settings',
            [
                'only' => [
                    'index',
                    'create',
                    'store',
                    'destroy',
                ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $generated_services=GeneratedService::get();
        return view('modules.process.catalogs.generated_services_index',compact('generated_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('modules.process.catalogs.generated_services_create');
        } catch (Throwable $e) {
            flash($e)->error();
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreGeneratedServiceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $response = $this->ajaxDispatch(new CreateGeneratedService($request));
            if ($response['success']) {
                $message = trans_choice('messages.success.added', 1, ['type' => trans('general.generated_service')]);
                flash($message)->success();
                return redirect()->route('generated_services.index');
            } else {
                $message = $response['message'];
                flash($message)->error();
                return redirect()->route('generated_services.create');
            }
        } catch (Throwable $e) {
            flash($e)->error();
            return redirect()->route('generated_services.create');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Process\Catalogs\GeneratedService $generatedService
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $response = $this->ajaxDispatch(new DeleteGeneratedService($id));
            if ($response['success']) {
                $message = trans_choice('messages.success.deleted', 1, ['type' => trans('general.generated_service')]);
                flash($message)->success();
                return redirect()->route('generated_services.index');
            } else {
                $message = $response['message'];
                flash($message)->error();
                return redirect()->route('generated_services.index');
            }
        } catch (Throwable $e) {
            flash($e)->error();
            return redirect()->route('generated_services.index');
        }
    }
}
