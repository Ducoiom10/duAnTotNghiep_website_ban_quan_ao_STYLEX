<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Voucher\VoucherRequest;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderByDesc('created_at')->paginate(12);

        $now = now();
        $stats = [
            'total' => Voucher::count(),
            'active' => Voucher::where('is_active', true)->count(),
            'valid_now' => Voucher::where('is_active', true)
                ->where(function ($q) use ($now) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
                })
                ->where(function ($q) use ($now) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
                })
                ->count(),
            'percent_type' => Voucher::where('type', 'percent')->count(),
            'fixed_type' => Voucher::where('type', 'fixed')->count(),
            'used_total' => (int) Voucher::sum('used_count'),
        ];

        return view('admin.vouchers.index', compact('vouchers', 'stats'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(VoucherRequest $request)
    {
        $data = $request->validated();
        Voucher::create($data);
        return redirect()->route('admin.vouchers.index')->with('success', 'Tạo voucher thành công');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(VoucherRequest $request, Voucher $voucher)
    {
        $data = $request->validated();
        $voucher->update($data);
        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật voucher thành công');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Đã xóa voucher');
    }
}


