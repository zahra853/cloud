@extends('admin.sidebar')

@section('container')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Vouchers Management</h1>
        <a href="{{ route('admin.vouchers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Add Voucher
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Discount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Purchase</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valid Until</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($vouchers as $voucher)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono font-bold text-purple-600">{{ $voucher->code }}</td>
                        <td class="px-6 py-4">
                            <p class="font-medium">{{ $voucher->name }}</p>
                            @if($voucher->member_only)
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Member Only</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($voucher->discount_type === 'percentage')
                                <span class="text-green-600 font-bold">{{ $voucher->discount_value }}%</span>
                                @if($voucher->max_discount)
                                    <span class="text-xs text-gray-500 block">Max Rp {{ number_format($voucher->max_discount, 0, ',', '.') }}</span>
                                @endif
                            @else
                                <span class="text-green-600 font-bold">Rp {{ number_format($voucher->discount_value, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($voucher->min_purchase > 0)
                                Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $voucher->used_count ?? 0 }} / {{ $voucher->usage_limit ?? '∞' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $voucher->valid_until ? $voucher->valid_until->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($voucher->is_active && (!$voucher->valid_until || $voucher->valid_until >= now()))
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="text-blue-600 hover:underline text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.vouchers.delete', $voucher) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this voucher?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            No vouchers yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
