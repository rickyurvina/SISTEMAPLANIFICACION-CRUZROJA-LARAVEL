<?php

namespace App\Http\Controllers\Auth;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Auth\UserRequest;
use App\Jobs\Admin\CreateContact;
use App\Jobs\Auth\CreateUser;
use App\Jobs\Auth\DeleteUser;
use App\Jobs\Auth\UpdateUser;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        if (user()->cannot('admin-crud-admin') && user()->cannot('admin-read-admin')) {
            abort(403);
        }

        $users = User::with(['media', 'roles','departments'])->collect();

        return view('auth.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::notSuperAdmin()->get();
        $companies = user()->companies()->get()->sortBy('name')->pluck('name', 'id');

        return view('auth.users.create', compact('roles', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     *
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {

        $response = $this->ajaxDispatch(new CreateUser($request));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.users', 1)]))->success();
            return redirect()->route('users.index');
        } else {
            flash($response['message'])->error();
            return redirect()->route('users.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::notSuperAdmin()->get();
        $userRolesIds = $user->roles->pluck('id');
        $companies = user()->companies()->get()->sortBy('name')->pluck('name', 'id');

        return view('auth.users.edit', compact('user', 'companies', 'roles', 'userRolesIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param UserRequest $request
     *
     * @return RedirectResponse
     */
    public function update(User $user, UserRequest $request): RedirectResponse
    {
        $response = $this->ajaxDispatch(new UpdateUser($user, $request));

        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.users', 1)]))->success();
            return redirect()->route('users.index');
        } else {
            flash($response['message'])->error();
            return redirect()->route('users.edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $response = $this->ajaxDispatch(new DeleteUser($user));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.users', 1)]))->success();
        } else {
            flash($response['message'])->error();
        }
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        $roles = Role::notSuperAdmin()->get();
        $userRolesIds = $user->roles->pluck('id');
        $companies = user()->companies()->get()->sortBy('name')->pluck('name', 'id');

        return view('auth.users.show', compact('user', 'companies', 'roles', 'userRolesIds'));
    }
}
