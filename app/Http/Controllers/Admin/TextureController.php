<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Texture;
use Illuminate\Http\Request;

class TextureController extends Controller
{
    public function index()
    {
        $textures = Texture::latest()->paginate(10);
        return view('admin.textures.index', compact('textures'));
    }

    public function create()
    {
        return view('admin.textures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        Texture::create($request->all());
        return redirect()->route('admin.textures.index')->with('success', 'Thêm chất liệu thành công!');
    }

    public function edit(Texture $texture)
    {
        return view('admin.textures.edit', compact('texture'));
    }

    public function update(Request $request, Texture $texture)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        $texture->update($request->all());
        return redirect()->route('admin.textures.index')->with('success', 'Cập nhật chất liệu thành công!');
    }

    public function destroy(Texture $texture)
    {
        $texture->delete();
        return redirect()->route('admin.textures.index')->with('success', 'Xóa chất liệu thành công!');
    }
}
