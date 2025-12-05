<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->paginate(10);
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        Size::create($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Thêm kích thước thành công!');
    }

    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        $size->update($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Cập nhật kích thước thành công!');
    }

    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Xóa kích thước thành công!');
    }
}
