<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    /**
     * Admin: Display all vouchers
     */
    public function index()
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Admin: Show create voucher form
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Admin: Store new voucher
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:vouchers,code',
            'description' => 'nullable|string|max:500',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'member_only' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Convert code to uppercase
        $validated['code'] = strtoupper($validated['code']);

        Voucher::create($validated);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil dibuat!');
    }

    /**
     * Admin: Show edit voucher form
     */
    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Admin: Update voucher
     */
    public function update(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'description' => 'nullable|string|max:500',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'member_only' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);

        $voucher->update($validated);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil diupdate!');
    }

    /**
     * Admin: Delete voucher
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil dihapus!');
    }

    /**
     * API: Validate voucher code
     */
    public function validateVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $voucher = Voucher::where('code', strtoupper($request->code))
            ->first();

        if (!$voucher) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode voucher tidak ditemukan',
            ], 404);
        }

        $user = auth()->user();
        $validation = $voucher->isValid($user, $request->subtotal);

        if (!$validation['valid']) {
            return response()->json($validation, 400);
        }

        $discount = $voucher->calculateDiscount($request->subtotal);

        return response()->json([
            'valid' => true,
            'message' => 'Voucher valid!',
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'discount_type' => $voucher->discount_type,
                'discount_value' => $voucher->discount_value,
                'discount_amount' => $discount,
            ],
        ]);
    }
}
