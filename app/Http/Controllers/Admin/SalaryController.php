<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{EmployeeSalary, User, RoleSalary};
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function index()
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);

        $salaries = EmployeeSalary::where('month', $month)
            ->where('year', $year)
            ->with('user:id,name,email')
            ->get();

        $totalSalary = $salaries->sum(fn($s) => $s->base_salary + $s->bonus - $s->deduction);

        return view('admin.salaries.index', compact('salaries', 'totalSalary', 'month', 'year'));
    }

    public function create()
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);
        $staffUsers = User::where('role', 2)->get();

        return view('admin.salaries.create', compact('staffUsers', 'month', 'year'));
    }

    public function store()
    {
        $data = request()->validate([
            'user_id' => 'required|exists:users,id',
            'base_salary' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric',
        ]);

        $data['bonus'] = $data['bonus'] ?? 0;
        
        // Nếu không có khấu trừ thủ công, tự động tính
        if (empty($data['deduction']) || $data['deduction'] == 0) {
            $data['deduction'] = $this->calculateAutoDeduction($data['base_salary'], $data['bonus']);
        }
        
        $data['status'] = 'pending';

        EmployeeSalary::updateOrCreate(
            ['user_id' => $data['user_id'], 'month' => $data['month'], 'year' => $data['year']],
            $data
        );

        return redirect()->route('admin.salaries.index', ['month' => $data['month'], 'year' => $data['year']])
            ->with('success', 'Lương nhân viên đã được lưu với khấu trừ tự động');
    }

    public function approve($id)
    {
        $salary = EmployeeSalary::findOrFail($id);
        $salary->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Đã phê duyệt lương');
    }

    public function pay($id)
    {
        $salary = EmployeeSalary::findOrFail($id);
        $salary->update(['status' => 'paid']);

        return redirect()->back()->with('success', 'Đã trả lương');
    }

    public function history()
    {
        $salaries = EmployeeSalary::with('user:id,name')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(20);

        return view('admin.salaries.history', compact('salaries'));
    }

    public function generateByRole()
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);
        $roleSalaries = RoleSalary::all();

        return view('admin.salaries.generate-by-role', compact('roleSalaries', 'month', 'year'));
    }

    public function storeByRole()
    {
        $data = request()->validate([
            'role' => 'required|numeric',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric',
        ]);

        $roleSalary = RoleSalary::where('role', $data['role'])->first();
        if (!$roleSalary) {
            return redirect()->back()->with('error', 'Không tìm thấy lương theo role');
        }

        $staffUsers = User::where('role', $data['role'])->get();
        $created = 0;

        foreach ($staffUsers as $user) {
            $baseSalary = $roleSalary->base_salary;
            $bonus = 0;
            
            // Tự động tính khấu trừ
            $deduction = $this->calculateAutoDeduction($baseSalary, $bonus);
            
            EmployeeSalary::updateOrCreate(
                ['user_id' => $user->id, 'month' => $data['month'], 'year' => $data['year']],
                [
                    'base_salary' => $baseSalary,
                    'bonus' => $bonus,
                    'deduction' => $deduction,
                    'status' => 'pending'
                ]
            );
            $created++;
        }

        return redirect()->route('admin.salaries.index', ['month' => $data['month'], 'year' => $data['year']])
            ->with('success', "Đã tạo lương cho $created nhân viên với khấu trừ tự động");
    }
    
    private function calculateAutoDeduction($baseSalary, $bonus = 0)
    {
        $totalIncome = $baseSalary + $bonus;
        
        // Các tỷ lệ khấu trừ theo quy định Việt Nam
        $BHXH_RATE = 0.08;  // 8%
        $BHYT_RATE = 0.015; // 1.5%
        $BHTN_RATE = 0.01;  // 1%
        $PERSONAL_DEDUCTION = 11000000; // 11 triệu VND giảm trừ bản thân
        
        // Tính BHXH, BHYT, BHTN (chỉ tính trên lương cơ bản)
        $socialInsurance = $baseSalary * ($BHXH_RATE + $BHYT_RATE + $BHTN_RATE);
        
        // Tính thuế thu nhập cá nhân
        $taxableIncome = max(0, $totalIncome - $socialInsurance - $PERSONAL_DEDUCTION);
        $personalTax = 0;
        
        // Bậc thuế lũy tiến
        if ($taxableIncome <= 5000000) {
            $personalTax = $taxableIncome * 0.05;
        } elseif ($taxableIncome <= 10000000) {
            $personalTax = 5000000 * 0.05 + ($taxableIncome - 5000000) * 0.10;
        } elseif ($taxableIncome <= 18000000) {
            $personalTax = 5000000 * 0.05 + 5000000 * 0.10 + ($taxableIncome - 10000000) * 0.15;
        } elseif ($taxableIncome <= 32000000) {
            $personalTax = 5000000 * 0.05 + 5000000 * 0.10 + 8000000 * 0.15 + ($taxableIncome - 18000000) * 0.20;
        } else {
            $personalTax = 5000000 * 0.05 + 5000000 * 0.10 + 8000000 * 0.15 + 14000000 * 0.20 + ($taxableIncome - 32000000) * 0.25;
        }
        
        return round($socialInsurance + $personalTax);
    }
}
