<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('admin.roles.index', ['roles' => Role::withCount('users')->get()]);
    }

    public function create(): View
    {
        return view('admin.roles.form', ['role' => new Role(), 'permissions' => Permission::all()->groupBy('group')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'permissions' => 'array']);
        $role = Role::create(['name' => $data['name'], 'slug' => \Illuminate\Support\Str::slug($data['name'])]);
        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Đã thêm vai trò.');
    }

    public function edit(Role $role): View
    {
        return view('admin.roles.form', [
            'role' => $role,
            'permissions' => Permission::all()->groupBy('group'),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'permissions' => 'array']);
        $role->update(['name' => $data['name']]);
        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Đã cập nhật vai trò.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        abort_if($role->slug === 'super-admin', 403, 'Không thể xoá vai trò Super Admin.');
        $role->delete();

        return back()->with('success', 'Đã xoá vai trò.');
    }
}
