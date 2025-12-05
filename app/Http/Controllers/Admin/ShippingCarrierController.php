<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShippingCarrierRequest;
use App\Models\ShippingCarrier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShippingCarrierController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $carriers = ShippingCarrier::query()
            ->when($q, fn($x)=>$x->where('name','like',"%$q%"))
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('admin.shipping_carriers.index', compact('carriers','q'));
    }

    public function create()
    {
        return view('admin.shipping_carriers.create');
    }

    public function store(ShippingCarrierRequest $request)
    {
        $data = $request->validated();
        // Chuẩn hóa code và active
        $data['code'] = isset($data['code']) && $data['code'] !== ''
            ? Str::upper($data['code'])
            : Str::upper(Str::slug($data['name'], ''));
        // Nếu form không gửi 'active' (đã bỏ checkbox), mặc định true
        $data['active'] = $request->has('active') ? $request->boolean('active') : true;

        ShippingCarrier::create($data);
        return redirect()->route('admin.shipping_carriers.index')
            ->with('success','Tạo đơn vị vận chuyển thành công');
    }

    public function edit(ShippingCarrier $shipping_carrier)
    {
        return view('admin.shipping_carriers.edit', compact('shipping_carrier'));
    }

    public function update(ShippingCarrierRequest $request, ShippingCarrier $shipping_carrier)
    {
        $data = $request->validated();
        $data['code'] = isset($data['code']) && $data['code'] !== ''
            ? Str::upper($data['code'])
            : $shipping_carrier->code; // giữ nguyên nếu không nhập
        $data['active'] = $request->boolean('active');

        $shipping_carrier->update($data);
        return redirect()->route('admin.shipping_carriers.index')
            ->with('success','Cập nhật đơn vị vận chuyển thành công');
    }

    public function destroy(ShippingCarrier $shipping_carrier)
    {
        try {
            // shipments.carrier_id dùng ON DELETE RESTRICT → nếu đã dùng, xóa sẽ lỗi.
            $shipping_carrier->delete();
            return back()->with('success','Đã xóa đơn vị vận chuyển');
        } catch (QueryException $e) {
            return back()->with('error','Không thể xóa vì đã phát sinh đơn hàng dùng đơn vị này.');
        }
    }
}
