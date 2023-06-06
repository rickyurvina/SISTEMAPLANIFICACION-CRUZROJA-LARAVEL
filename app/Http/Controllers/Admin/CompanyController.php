<?php

namespace App\Http\Controllers\Admin;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Admin\CompanyRequest;
use App\Jobs\Admin\DeleteCompany;
use App\Jobs\Admin\UpdateCompany;
use App\Models\Admin\Company;
use App\Traits\Users;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CompanyController extends Controller
{
    use Users;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('azure');
        $this->middleware('permission:admin-manage-companies|admin-view-companies', ['only' => ['index']]);
        $this->middleware('permission:admin-manage-companies', ['only' => ['create','update','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $companies = Company::collect();
        return view('modules.admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return RedirectResponse
     */
    public function show()
    {
        return redirect()->route('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function create()
    {
        return view('modules.admin.companies.create');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Company $company)
    {

        $levels = config('constants.catalog.LEVELS');
        $list_parents = [];
        if ($company->level > 1) {
            $list_parents = Company::getParents($company->level);
        }
        return view('modules.admin.companies.edit')
            ->with(compact('company', 'levels', 'list_parents'))
            ->with('id', $company->id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Company $company
     * @param CompanyRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Company $company, CompanyRequest $request)
    {
        dispatch_now(new UpdateCompany([
            'id' => $company->id,
            'name' => $request->input('name'),
            'identification' => $request->input('identification'),
            'phone' => $request->input('phone'),
            'fax' => $request->input('fax'),
            'level' => $request->input('level'),
            'web_site' => $request->input('webSite'),
            'description' => $request->input('description'),
            'parent_id' => $request->input('parent')
        ]));
        flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.companies', 1)]))->success();
        return redirect(route('companies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return RedirectResponse
     */
    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);
        $response = $this->ajaxDispatch(new DeleteCompany($company));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 1, ['type' => trans_choice('general.companies', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('companies.index');
    }

    /**
     * Change the active company.
     *
     * @param Company $company
     *
     * @return RedirectResponse
     */
    public function switch(Company $company): RedirectResponse
    {
        if ($this->isUserCompany($company->id)) {
            session(['company_id' => $company->id]);
            loadSettings();
        }
        return redirect()->route('common.home');
    }
}
