<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * @phpstan-ignore-next-line
     */
    public function index(){
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Admin dashboard với đầy đủ quyền
            return view('admin.dashboard', [
                'userRole' => 'admin',
                'dashboardTitle' => 'Admin Dashboard',
                'permissions' => [
                    'manage_users' => true,
                    'manage_roles' => true,
                    'manage_products' => true,
                    'manage_categories' => true,
                    'manage_posts' => true,
                    'manage_loyalty' => true,
                    'manage_tax_shipping' => true,
                    'view_reports' => true
                ]
            ]);
        } elseif ($user->isStaff()) {
            // Staff dashboard với quyền hạn chế
            return view('admin.dashboard', [
                'userRole' => 'staff',
                'dashboardTitle' => 'Staff Dashboard',
                'permissions' => [
                    'manage_users' => false,
                    'manage_roles' => false,
                    'manage_products' => true,
                    'manage_categories' => true,
                    'manage_posts' => true,
                    'manage_loyalty' => false,
                    'manage_tax_shipping' => false,
                    'view_reports' => true
                ]
            ]);
        }
        
        // Fallback - không nên xảy ra vì đã có middleware checkRole
        return redirect()->route('loginView')->with('error', 'Không có quyền truy cập');
    }
}
