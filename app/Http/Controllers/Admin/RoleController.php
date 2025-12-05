<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Chỉ hiển thị Admin và Staff, không hiển thị User
            $query = User::query()->whereIn('role', [1, 2])->orderByRaw('CASE 
                WHEN role = 1 THEN 1 
                WHEN role = 2 THEN 2 
                ELSE 3 
            END')->latest('id');

            // Filter by role
            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Search by name or email
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            }

            $users = $query->paginate(10);
            
            // Get role statistics - chỉ đếm Admin và Staff
            $roleStats = User::whereIn('role', [1, 2])->selectRaw('
                count(*) as total_users,
                sum(role = 1) as admin_count,
                sum(role = 2) as staff_count
            ')->first();

            return view('admin.roles.index', compact('users', 'roleStats'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }

    public function updateRole(Request $request, User $user)
    {
        try {
            $request->validate([
                'role' => 'required|in:1,2' // Chỉ cho phép Admin hoặc Staff
            ]);

            // Kiểm tra nếu đang thay đổi admin cuối cùng thành staff
            if ($user->role == User::ROLE_ADMIN && $request->role == User::ROLE_STAFF) {
                $adminCount = User::where('role', User::ROLE_ADMIN)->count();
                if ($adminCount <= 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể thay đổi admin cuối cùng thành staff! Hệ thống cần ít nhất 1 tài khoản admin.'
                    ], 400);
                }
            }

            $user->update([
                'role' => $request->role,
                'is_admin' => $request->role == 1 ? 1 : 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật quyền thành công',
                'role_name' => $user->role_name
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ], 500);
        }
    }

    public function bulkUpdateRoles(Request $request)
    {
        try {
            $request->validate([
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,id',
                'role' => 'required|in:0,1,2'
            ]);

            DB::transaction(function () use ($request) {
                User::whereIn('id', $request->user_ids)
                    ->update([
                        'role' => $request->role,
                        'is_admin' => $request->role == 1 ? 1 : 0
                    ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật quyền hàng loạt thành công'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ], 500);
        }
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function edit(User $user)
    {
        return view('admin.roles.edit', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|in:1,2', // Chỉ cho phép Admin (1) hoặc Staff (2)
                'status' => 'required|in:active,inactive,blocked'
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_admin' => $request->role == 1 ? 1 : 0,
                'status' => $request->status,
                'email_verified_at' => now()
            ]);

            return redirect()->route('admin.roles.index')->with('success', 'Tạo tài khoản thành công!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau')->withInput();
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:6',
                'role' => 'required|in:1,2', // Chỉ cho phép Admin (1) hoặc Staff (2)
                'status' => 'required|in:active,inactive,blocked'
            ]);

            // Kiểm tra nếu đang sửa admin cuối cùng
            if ($user->role == User::ROLE_ADMIN) {
                $adminCount = User::where('role', User::ROLE_ADMIN)->count();
                if ($adminCount <= 1) {
                    // Nếu đang thay đổi role từ admin sang staff
                    if ($request->role == User::ROLE_STAFF) {
                        return redirect()->back()->with('error', 'Không thể thay đổi admin cuối cùng thành staff! Hệ thống cần ít nhất 1 tài khoản admin.')->withInput();
                    }
                    
                    // Nếu đang thay đổi status thành inactive hoặc blocked
                    if (in_array($request->status, ['inactive', 'blocked'])) {
                        return redirect()->back()->with('error', 'Không thể vô hiệu hóa admin cuối cùng! Hệ thống cần ít nhất 1 tài khoản admin hoạt động.')->withInput();
                    }
                }
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'is_admin' => $request->role == 1 ? 1 : 0,
                'status' => $request->status
            ];

            // Chỉ cập nhật password nếu có
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()->route('admin.roles.index')->with('success', 'Cập nhật tài khoản thành công!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau')->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            // Không cho phép xóa chính mình
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không thể xóa chính tài khoản của mình!'
                ], 400);
            }

            // Kiểm tra nếu đang xóa admin và chỉ còn 1 admin duy nhất
            if ($user->role == User::ROLE_ADMIN) {
                $adminCount = User::where('role', User::ROLE_ADMIN)->count();
                if ($adminCount <= 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể xóa admin cuối cùng! Hệ thống cần ít nhất 1 tài khoản admin.'
                    ], 400);
                }
            }

            // Xóa user hoàn toàn khỏi database
            $user->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa tài khoản thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ], 500);
        }
    }

    public function checkAdminCount()
    {
        $adminCount = User::where('role', User::ROLE_ADMIN)->count();
        return response()->json(['admin_count' => $adminCount]);
    }
}
