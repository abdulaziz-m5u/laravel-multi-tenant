<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\UserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
   
    public function index(): View
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $users = User::get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $roles = Role::pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        if($request->validated()) {
            $user = User::create($request->except('password') + ['password' => bcrypt($request->password)]);
        }
        $user->roles()->sync($request->input('roles'));

        return redirect()->route('admin.users.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(User $user): View
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if($request->validated()) {
            if(Hash::check($request->input('password'), bcrypt($user->password))){
                $user->update($request->except('password'));
            }else {
                $user->update($request->except('password') + ['password' => bcrypt($request->password)]);
            }
            $user->roles()->sync($request->input('roles'));
        }

        return redirect()->route('admin.users.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $user->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}