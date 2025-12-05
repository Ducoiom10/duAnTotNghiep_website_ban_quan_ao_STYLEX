<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionEntityController extends Controller
{
    public function index()
    {
        $permissions = Permission::query()->orderByDesc('id')->paginate(10);
        return view('admin.rbac.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.rbac.permissions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:permissions,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Permission::create($data);
        return redirect()->route('admin.rbac.permissions.index')->with('success', 'Tạo permission thành công');
    }

    public function edit(Permission $permission)
    {
        return view('admin.rbac.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:permissions,name,' . $permission->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $permission->update($data);
        return redirect()->route('admin.rbac.permissions.index')->with('success', 'Cập nhật permission thành công');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.rbac.permissions.index')->with('success', 'Đã xóa permission');
    }
}


