<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaxRate\TaxRateRequest;
use App\Models\TaxRate;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $taxRates = TaxRate::query()
            ->when($q, fn($x)=>$x->where('name','like',"%$q%"))
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('admin.tax_rates.index', compact('taxRates','q'));
    }

    public function create()
    {
        return view('admin.tax_rates.create');
    }

    public function store(TaxRateRequest $request)
    {
        TaxRate::create($request->validated());
        return redirect()->route('admin.tax_rates.index')
            ->with('success','Tạo thuế thành công');
    }

    public function edit(TaxRate $tax_rate)
    {
        return view('admin.tax_rates.edit', compact('tax_rate'));
    }

    public function update(TaxRateRequest $request, TaxRate $tax_rate)
    {
        $tax_rate->update($request->validated());
        return redirect()->route('admin.tax_rates.index')
            ->with('success','Cập nhật thuế thành công');
    }

    public function destroy(TaxRate $tax_rate)
    {
        try {
            $tax_rate->delete(); // order_items.tax_rate_id có ràng buộc ON DELETE SET NULL → xóa được
            return back()->with('success','Đã xóa mức thuế');
        } catch (QueryException $e) {
            return back()->with('error','Không thể xóa mức thuế: '.$e->getMessage());
        }
    }
}
