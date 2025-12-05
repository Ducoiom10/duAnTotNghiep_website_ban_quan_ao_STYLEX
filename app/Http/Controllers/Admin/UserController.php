<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Traits\LoggableTrait;
use App\Traits\UploadToLocalTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use LoggableTrait, UploadToLocalTrait;
    const FOLDER = 'users';
    const URLIMAGEDEFAULT = "https://res.cloudinary.com/dvrexlsgx/image/upload/v1732148083/Avatar-trang-den_apceuv_pgbce6.png";
    public function index(Request $request)
    {
        $queryUsers = User::query()->latest('id');

        // Staff chỉ được xem User (role = 0), Admin xem User và Staff (role = 0,2)
        if (auth()->user() && auth()->user()->role === User::ROLE_STAFF) {
            $queryUsers->where('role', User::ROLE_USER);
        } elseif (auth()->user() && auth()->user()->role === User::ROLE_ADMIN) {
            $queryUsers->whereIn('role', [User::ROLE_USER, User::ROLE_STAFF]);
        }

        if ($request->filled('name')) {
            $queryUsers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $queryUsers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('phone_number')) {
            $queryUsers->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }
        if ($request->filled('status')) {
            $queryUsers->where('status', $request->status);
        }
        if ($request->filled('role')) {
            $queryUsers->where('role', $request->role);
        }

        // Thống kê - Admin xem đầy đủ, Staff chỉ xem users thường
        $queryUserCounts = User::query();
        
        // Staff chỉ được xem thống kê User (role = 0)
        if (auth()->user() && auth()->user()->role === User::ROLE_STAFF) {
            $queryUserCounts->where('role', User::ROLE_USER);
        }
        
        $queryUserCounts->selectRaw('
                    count(id) as total_users,
                    sum(status = "active") as active_users,
                    sum(status = "inactive") as inactive_users,
                    sum(status = "blocked") as blocked_users,
                    sum(role = 1) as admin_count,
                    sum(role = 2) as staff_count,
                    sum(role = 0) as user_count
                ');
        $items = $queryUsers->paginate(10);
        $userCounts = $queryUserCounts->first();
        return view('admin.users.index', compact('items', 'userCounts'));
    }
    public function create()
    {
        try {
            return view('admin.users.create');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->except('avatar');

            if ($request->hasFile('avatar')) {
                $urlAvatar = $this->uploadToLocal($request->file('avatar'), self::FOLDER);
                $data['avatar'] = $urlAvatar;
            }

            // Luôn tạo User (role=0, is_admin=0)
            $data['role'] = 0;
            $data['is_admin'] = 0;
            $data['email_verified_at'] = now();
            
            $user = User::query()->create($data);

            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'Thêm mới thành công');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($urlAvatar) && filter_var($urlAvatar, FILTER_VALIDATE_URL)) {
                $this->deleteFromLocal($urlAvatar, self::FOLDER);
            }

            $this->logError($e);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
    public function updateEmailVerified(Request $request, User $user)
    {
        try {
            $isChecked = $request->input('email_verified') == '1' || $request->input('email_verified') === true;

            // Nếu admin bật xác thực cho user chưa xác thực
            if (!$user->email_verified_at && $isChecked) {
                $user->update(['email_verified_at' => now()]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Email đã được xác thực thành công.'
                ]);
            }

            // Nếu admin tắt xác thực cho user đã xác thực
            if ($user->email_verified_at && !$isChecked) {
                $user->update(['email_verified_at' => null]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Email đã được hủy xác thực.'
                ]);
            }

            return response()->json([
                'status' => 'info',
                'message' => 'Không có thay đổi nào.'
            ]);
        } catch (\Exception $e) {
            $this->logError($e);

            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật thất bại: ' . $e->getMessage()
            ]);
        }
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        // Nếu là Staff: chỉ được cập nhật trạng thái user
        if (auth()->user() && auth()->user()->role === User::ROLE_STAFF) {
            $validated = \request()->validate([
                'status' => ['required', 'in:active,inactive,blocked'],
            ]);

            $oldStatus = $user->status;
            $user->update(['status' => $validated['status']]);
            if ($oldStatus !== $user->status) {
                event(new UserStatusChanged($user, $oldStatus, $user->status, 'Người dùng', 'Người dùng'));
            }
            return redirect()->route('admin.users.edit', $user)->with('success', 'Cập nhật trạng thái thành công');
        }

        $validator = $request->validated();
        $data = $request->except('avatar', 'email', 'email_verified', 'is_admin', 'role');

        DB::beginTransaction();

        try {
            $oldAvatar = $user->avatar;
            $oldRole = $user->is_admin ? "Quản trị viên" :'Người dùng';
            $oldStatus = $user->status;

            if ($request->hasFile('avatar')) {
                $avatarFile = $request->file('avatar');
                $data['avatar'] = $this->uploadToLocal($avatarFile, self::FOLDER);
            }

            $user->update($data);

            $newRole = $user->is_admin ? "Quản trị viên" :'Người dùng' ;
            $newStatus = $user->status;

            if ($oldRole !== $newRole || $oldStatus !== $newStatus) {
                event(new UserStatusChanged($user, $oldStatus, $newStatus, $oldRole, $newRole));
            }

            if (!empty($data['avatar']) && !empty($oldAvatar) && $oldAvatar !== self::URLIMAGEDEFAULT) {
                $this->deleteFromLocal($oldAvatar, self::FOLDER);
            }

            DB::commit();
            return redirect()->route('admin.users.edit', $user)->with('success', 'Cập nhật thành công');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($data['avatar'])) {
                $this->deleteFromLocal($data['avatar'], self::FOLDER);
            }

            $this->logError($e);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
    public function destroy(User $user)
{
    try {
        if ($user->is_admin) {
            return redirect()->back()->with('warning', 'Không thể xóa tài khoản quản trị viên!');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Đã chuyển vào thùng rác!');
    } catch (\Exception $e) {
        $this->logError($e);

        return redirect()
            ->back()
            ->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
    }
}

    public function trash()
    {
        try {
            $usersDeleted = User::onlyTrashed()->latest('id')->paginate(10);
            return view('admin.users.trash', compact('usersDeleted'));
        } catch (\Exception $e) {
            $this->logError($e);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
    public function restore($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();
            return redirect()->route('admin.users.trash')->with('success', 'Khôi phục người dùng thành công');
        } catch (\Exception $e) {
            $this->logError($e);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
    public function forceDelete($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->forceDelete();
            return redirect()->route('admin.users.trash')->with('success', 'Xóa cứng người dùng thành công');
        } catch (\Exception $e) {
            $this->logError($e);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }

    /**
     * Hiển thị thông tin profile của user hiện tại
     */
    public function profile()
    {
        $user = auth()->user();
        return view('admin.users.profile', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa profile
     */
    public function editProfile()
    {
        $user = auth()->user();
        return view('admin.users.edit-profile', compact('user'));
    }

    /**
     * Cập nhật thông tin profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = $request->only(['name', 'phone_number']);
            
            // Xử lý upload avatar nếu có
            if ($request->hasFile('avatar')) {
                // Xóa avatar cũ nếu có
                if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                    \Storage::disk('public')->delete($user->avatar);
                }
                
                // Upload avatar mới
                $avatar = $request->file('avatar');
                $avatarName = time() . '_' . $avatar->getClientOriginalName();
                $avatarPath = $avatar->storeAs(self::FOLDER, $avatarName, 'public');
                $data['avatar'] = $avatarPath;
            }

            $user->update($data);

            return redirect()->route('admin.profile')
                ->with('success', 'Cập nhật thông tin thành công!');
                
        } catch (\Exception $e) {
            $this->logError($e);
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật thông tin!');
        }
    }
}
