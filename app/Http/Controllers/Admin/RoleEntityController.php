<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleEntityController extends Controller
{
    public function index()
    {
        $roles = Role::query()->orderByDesc('id')->paginate(10);
        return view('admin.rbac.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.rbac.roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Role::create($data);
        return redirect()->route('admin.rbac.roles.index')->with('success', 'Tạo role thành công');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $assigned = $role->permissions()->pluck('permissions.id')->toArray();
        return view('admin.rbac.roles.edit', compact('role', 'permissions', 'assigned'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name,' . $role->id],
            'description' => ['nullable', 'string', 'max:255'],
            'permission_ids' => ['array'],
            'permission_ids.*' => ['exists:permissions,id'],
        ]);

        $role->update($data);
        if ($request->has('permission_ids')) {
            $role->permissions()->sync($request->permission_ids);
        }
        return redirect()->route('admin.rbac.roles.index')->with('success', 'Cập nhật role thành công');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.rbac.roles.index')->with('success', 'Đã xóa role');
    }
}


