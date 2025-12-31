@extends('admin.sidebar')

@section('container')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Voucher</h1>
        <a href="{{ route('admin.vouchers.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Voucher Code</label>
                    <input type="text" name="code" value="{{ old('code') }}" 
                           class="w-full px-4 py-2 border rounded-lg uppercase"
                           placeholder="e.g., PROMO50" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Voucher Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full px-4 py-2 border rounded-lg"
                           placeholder="e.g., Promo Akhir Tahun" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="2" 
                              class="w-full px-4 py-2 border rounded-lg">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Discount Type</label>
                    <select name="discount_type" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Fixed (Rp)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Discount Value</label>
                    <input type="number" name="discount_value" value="{{ old('discount_value') }}" 
                           class="w-full px-4 py-2 border rounded-lg"
                           placeholder="10 or 50000" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Min Purchase (Rp)</label>
                    <input type="number" name="min_purchase" value="{{ old('min_purchase', 0) }}" 
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Max Discount (Rp)</label>
                    <input type="number" name="max_discount" value="{{ old('max_discount') }}" 
                           class="w-full px-4 py-2 border rounded-lg"
                           placeholder="Optional">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Usage Limit</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" 
                           class="w-full px-4 py-2 border rounded-lg"
                           placeholder="Leave empty for unlimited">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Valid From</label>
                    <input type="date" name="valid_from" value="{{ old('valid_from', date('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Valid Until</label>
                    <input type="date" name="valid_until" value="{{ old('valid_until') }}" 
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="col-span-2 flex gap-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="member_only" value="1" {{ old('member_only') ? 'checked' : '' }}>
                        <span>Member Only</span>
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span>Active</span>
                    </label>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i> Create Voucher
                </button>
            </div>
        </form>
    </div>
@endsection
