@extends('admin.layouts.app')
@section('title', 'Lý do nên chọn')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <span>Lý do nên chọn</span>
        <a href="{{ route('admin.store-benefits.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm nội dung</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Icon</th><th>Tiêu đề</th><th>Mô tả</th><th>Thứ tự</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @forelse($benefits as $benefit)
                    @php($translation = $benefit->translation())
                    <tr>
                        <td><i class="{{ $benefit->icon }} fs-5"></i></td>
                        <td>{{ $translation?->title }}</td>
                        <td>{{ $translation?->description }}</td>
                        <td>{{ $benefit->sort_order }}</td>
                        <td>{!! $benefit->is_active ? '<span class="badge bg-success">Hiển thị</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.store-benefits.edit', $benefit) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.store-benefits.destroy', $benefit) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá nội dung này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4">Chưa có nội dung.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $benefits->links() }}</div>
</div>
@endsection
