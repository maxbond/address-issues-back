<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', ['users' => User::withTrashed()->paginate(config('pagination.per_page'))]);
    }

    /**
     * Create user form
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Edit user form
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Create a new user
     *
     * @param CreateuserRequest $request
     * @return RedirectResponse
     */
    public function store(CreateuserRequest $request): RedirectResponse
    {
        User::create($request->validated());
        return redirect(route('admin.users.index'));
    }

    /**
     * Update user
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        if (!$data['password']) {
            unset($data['password']);
        }
        $user->fill($data)->save();
        return redirect(route('admin.users.index'));
    }

    /**
     * Delete user
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect(route('admin.users.index'));
    }

    /**
     * Restore user
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function restore(User $user): RedirectResponse
    {
        $user->restore();
        return redirect(route('admin.users.index'));
    }
}
