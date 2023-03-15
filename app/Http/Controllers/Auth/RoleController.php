<?php

namespace App\Http\Controllers\Auth;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Auth\RoleRequest;
use App\Jobs\Auth\CreateRole;
use App\Jobs\Auth\DeleteRole;
use App\Jobs\Auth\UpdateRole;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Exception;
use Faker\Guesser\Name;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Illuminate\Support\MessageBag;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        if (user()->can('admin-crud-admin') && user()->can('admin-read-admin')) {
            $roles = Role::notSuperAdmin()->collect();

            return view('auth.roles.index', compact('roles'));
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function create()
    {
        if (user()->can('admin-crud-admin')) {
            $permissions = [];
            $actions = ['project','strategy','budget', 'poa', 'admin','process'];

            foreach ($actions as $action) {
                $permissions[$action] = Permission::action($action)->get()->sortBy('title')->all();
            }
            return view('auth.roles.create', compact('actions', 'permissions'));
        }else{
            abort(403);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     *
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
//        $res = $this->addRoleToAzure($request->request->get('name'));
//        $request->request->set('id_azuread_rol', strtolower($res->idAzureadRol));
        $response = $this->ajaxDispatch(new CreateRole($request));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.roles', 1)]))->success();
            return redirect()->route('roles.index');
        } else {
            flash($response['message'])->error();
            return redirect()->route('roles.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(Role $role)
    {
        if (user()->can('admin-crud-admin')||user()->can('admin-manage-roles')) {
            $permissions = [];
            $actions = ['project','strategy','budget', 'poa', 'admin','process'];

            foreach ($actions as $action) {
                $permissions[$action] = Permission::action($action)->get()->sortBy('title')->all();
            }

            return view('auth.roles.edit', compact('role', 'actions', 'permissions'));
        }else{
            abort(403);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param Role $role
     * @param RoleRequest $request
     *
     * @return RedirectResponse
     */
    public function update(Role $role, RoleRequest $request): RedirectResponse
    {
        $response = $this->ajaxDispatch(new UpdateRole($role, $request));

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.roles', 1)]))->success();
            return redirect()->route('roles.index');
        } else {
            flash($response['message'])->error();
            return redirect()->route('roles.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
//        $res = $this->deleteRoleToAzure($role->id_azuread_rol);
        $response = $this->ajaxDispatch(new DeleteRole($role));

        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.roles', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }

        return redirect()->route('roles.index');
    }

    /**
     * Get roles list from Azure AD.
     *
     * @return array
     */
//    public function getRolesFromAzure() {
//        $azureToken = session('azureToken');
//        $graph = new Graph();
//        $graph->setApiVersion("v1.0")
//            ->setAccessToken($azureToken);
//
//        $resourceId = env('AZURE_RESOURCE_ID', '4e7537c4-af92-490d-a339-849cc9ecb821');
//        $uri = '/servicePrincipals' . '/' . $resourceId;
//        $allRoles = $graph->createRequest("GET", $uri)
//                    ->addHeaders(array("Content-Type" => "application/json"))
//                    ->setReturnType(Model\ServicePrincipal::class)
//                    ->execute();
//        return $allRoles->getAppRoles();
//    }

    /**
     * Add role from cre to Azure AD.
     *
     * @param String $rolName
     */
//    public function addRoleToAzure($rolName) {
//        $azureToken = session('azureToken');
//        $graph = new Graph();
//        $graph->setApiVersion("v1.0")
//            ->setAccessToken($azureToken);
//
//        $auxArray = $this->getRolesFromAzure();
//        $guid = $this->getGUID();
//        array_push($auxArray, [
//            "allowedMemberTypes"=> [
//                "User"
//            ],
//            "description"=> $rolName,
//            "displayName"=> $rolName,
//            "id"=> $guid,
//            "isEnabled"=> true,
//            "origin"=> "Application",
//            "value"=> $rolName
//        ]);
//
//        $resource = env('AZURE_RESOURCE', '6fb16186-4560-4eb7-acc6-6681d2bc1963');
//        $uri = '/applications' . '/' . $resource;
//        $body = json_encode(['appRoles' => $auxArray]);
//        try{
//        $serviceRol = $graph->createRequest("PATCH", $uri)
//                    ->addHeaders(array("Content-Type" => "application/json"))
//                    ->attachBody($body)
//                    ->setReturnType(Model\Application::class)
//                    ->execute();
//        } catch(Exception $e) {
//            return redirect()->back()->withErrors(new MessageBag(['Hubo un error al ejecutar su transacción']));
//        }
//
//        $serviceRol->idAzureadRol = $guid;
//
//        return $serviceRol;
//    }

    /**
     * Set unavailable a rol in Azure AD.
     *
     */
    public function deleteRoleToAzure($rolIdAzure) {
        $azureToken = session('azureToken');
        $graph = new Graph();
        $graph->setApiVersion("v1.0")
            ->setAccessToken($azureToken);


        $auxArray = $this->getRolesFromAzure();
        $rolesArray = [];
        foreach($auxArray as $aux) {
            if($aux['id'] == $rolIdAzure) {
                $aux['isEnabled'] = false;
            }
            array_push($rolesArray, $aux);
        }

        $resource = env('AZURE_RESOURCE', '');
        $uri = '/applications' . '/' . $resource;
        $body = json_encode(['appRoles' => $rolesArray]);
        try {
            $serviceRol = $graph->createRequest("PATCH", $uri)
                ->addHeaders(array("Content-Type" => "application/json"))
                ->attachBody($body)
                ->setReturnType(Model\Application::class)
                ->execute();
        } catch(Exception $e) {
            return redirect()->back()->withErrors(new MessageBag(['Hubo un error al ejecutar su transacción']));
        }

        return $serviceRol;
    }

    /**
     * Return a guid string.
     *
     */
    public function getGUID() {
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
            return $uuid;
        }
    }
}