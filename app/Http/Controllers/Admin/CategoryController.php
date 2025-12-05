<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Traits\LoggableTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    //
    use LoggableTrait;
    public function index(){
        try {
            //code...
            // Paginate parent categories and eager-load children for display
            $parentCategories = Category::with('children')->whereNull('parent_id')->paginate(5);
            // Full list for the parent select in the add/edit forms
            $selectableCategories = Category::all();

            // Thống kê danh mục
            $categoryStats = [
                'total_categories' => Category::count(),
                'active_categories' => Category::where('status', 1)->count(),
                'inactive_categories' => Category::where('status', 0)->count(),
                'parent_categories' => Category::whereNull('parent_id')->count()
            ];

            return view('admin.category.index', compact(['parentCategories', 'selectableCategories', 'categoryStats']));
        } catch (\Exception $e) {
            $this->logError($e);
            return view('admin.category.index', [
                'parentCategories' => collect(),
                'selectableCategories' => collect(),
                'categoryStats' => [
                    'total_categories' => 0,
                    'active_categories' => 0,
                    'inactive_categories' => 0,
                    'parent_categories' => 0
                ],
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id){
        try {
            $category = Category::findOrFail($id);
            // Chỉ lấy danh mục cha (parent_id = null) và loại trừ danh mục hiện tại
            $selectableCategories = Category::where('id', '!=', $id)
                ->whereNull('parent_id')
                ->get();
            return view('admin.category.edit', compact('category', 'selectableCategories'));
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Không tìm thấy danh mục!');
        }
    }

    public function show($id){
        try {
            $category = Category::findOrFail($id);
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        } catch (\Exception $e) {
            $this->logError($e);
            return response()->json([
                'success' => false,
                'msg' => 'Không tìm thấy danh mục!'
            ]);
        }
    }

    public function update(UpdateCategoryRequest $request, $id){
        try {
            $category = Category::findOrFail($id);

            $oldStatus = $category->status;
            $newStatus = $request->status;

            $category->update([
                'name' => $request->category_name,
                'parent_id' => $request->parent_id ?: null,
                'status' => $newStatus
            ]);

            // Xử lý logic thay đổi trạng thái
            if ($oldStatus != $newStatus) {
                if ($oldStatus == 1 && $newStatus == 0) {
                    // Nếu tắt trạng thái hoạt động của danh mục cha, tắt luôn tất cả danh mục con
                    $this->deactivateChildren($category->id);
                } elseif ($oldStatus == 0 && $newStatus == 1) {
                    // Nếu bật trạng thái hoạt động của danh mục cha, kiểm tra danh mục cha của nó
                    if ($category->parent_id) {
                        $parent = Category::find($category->parent_id);
                        if ($parent && $parent->status == 0) {
                            // Nếu danh mục cha không hoạt động, không cho phép bật danh mục con
                            return response()->json([
                                'success' => false,
                                'msg' => 'Không thể kích hoạt danh mục con khi danh mục cha đang không hoạt động!'
                            ]);
                        }
                    }
                    // Nếu là danh mục cha (không có parent_id), kích hoạt lại các danh mục con
                    if (!$category->parent_id) {
                        $this->activateChildren($category->id);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'msg' => 'Cập nhật danh mục thành công!'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            $this->logError($e);
            return response()->json([
                'success' => false,
                'msg' => 'Có lỗi xảy ra khi cập nhật danh mục: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $category = Category::findOrFail($id);
            $childrenCount = $category->children()->count();
            
            // Xóa tất cả danh mục con trước
            if ($childrenCount > 0) {
                $category->children()->delete();
            }
            
            $category->delete();

            $message = $childrenCount > 0 
                ? "Xóa danh mục và {$childrenCount} danh mục con thành công!" 
                : "Xóa danh mục thành công!";

            return response()->json([
                'success' => true,
                'msg' => $message
            ]);
        } catch (\Exception $e) {
            $this->logError($e);
            return response()->json([
                'success' => false,
                'msg' => 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage()
            ]);
        }
    }
    public function store(StoreCategoryRequest $request){
        try {
            Category::create([
                'name' => $request->category_name,
                'parent_id' => $request->parent_id 
            ]);

           return response()->json([
                'success' => true,
                'msg' => 'Thêm Danh Mục Thành Công!'
           ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
               $this->logError($e);
                return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
           ], 500);
        }
    }

    /**
     * Tắt trạng thái hoạt động của tất cả danh mục con
     */
    private function deactivateChildren($parentId)
    {
        $children = Category::where('parent_id', $parentId)->get();
        
        foreach ($children as $child) {
            $child->update(['status' => 0]);
            // Đệ quy để tắt cả danh mục con của danh mục con
            $this->deactivateChildren($child->id);
        }
    }

    /**
     * Kích hoạt lại các danh mục con khi danh mục cha được kích hoạt
     */
    private function activateChildren($parentId)
    {
        $children = Category::where('parent_id', $parentId)->get();
        
        foreach ($children as $child) {
            // Chỉ kích hoạt nếu danh mục con trước đó đang hoạt động
            // hoặc nếu không có thông tin về trạng thái trước đó
            $child->update(['status' => 1]);
            // Đệ quy để kích hoạt cả danh mục con của danh mục con
            $this->activateChildren($child->id);
        }
    }
}