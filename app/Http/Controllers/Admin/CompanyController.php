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

    //Uploads

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (user()->can('admin-crud-admin') || user()->can('admin-read-admin') || user()->can('admin-manage-companies')) {
            $companies = Company::collect();
            return view('modules.admin.companies.index', compact('companies'));
        }else{
            abort(403);
        }
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
        if (user()->can('admin-crud-admin')) {
            return view('modules.admin.companies.create');
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     *
     * @return RedirectResponse
     */
    public function store(CompanyRequest $request)
    {

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
        if (user()->can('admin-crud-admin')) {
            $levels = config('constants.catalog.LEVELS');
            $list_parents = [];
            if ($company->level > 1) {
                $list_parents = Company::getParents($company->level);
            }
            return view('modules.admin.companies.edit')
                ->with(compact('company','levels', 'list_parents'))
                ->with('id',$company->id);
        }else{
            abort(403);
        }

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
     * Enable the specified resource.
     *
     * @param Company $company
     *
     * @return Response
     */
    public function enable(Company $company)
    {

    }

    /**
     * Disable the specified resource.
     *
     * @param Company $company
     *
     * @return Response
     */
    public function disable(Company $company)
    {

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
