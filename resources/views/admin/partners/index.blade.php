@extends('admin.layouts.app')
@section('title', 'Đối tác')
@section('content')
@php($bulkDeleteFormId = 'bulk-delete-partners')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý đối tác
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-excel"></i> Xuất Excel
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.partners.export.current', request()->query()) }}"><i class="fas fa-list me-2"></i>Xuất danh sách hiện tại</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.partners.export.all') }}"><i class="fas fa-layer-group me-2"></i>Xuất tất cả danh sách</a></li>
                </ul>
            </div>
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal-partners">
                <i class="fas fa-file-import"></i> Import Excel
            </button>
            <a href="{{ route('admin.partners.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm đối tác
            </a>
        </div>
    </div>
    @include('admin.partials.bulk-delete-toolbar', ['formId' => $bulkDeleteFormId, 'routeName' => 'admin.partners.bulk-destroy'])
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th><input type="checkbox" class="form-check-input" data-bulk-select="{{ $bulkDeleteFormId }}" aria-label="Chọn tất cả trên trang"></th>
                    <th>Tên đối tác</th>
                    <th>Người liên hệ</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Sản phẩm</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td><input type="checkbox" class="form-check-input" name="ids[]" value="{{ $partner->id }}" form="{{ $bulkDeleteFormId }}" data-bulk-delete-form="{{ $bulkDeleteFormId }}" aria-label="Chọn đối tác {{ $partner->name }}"></td>
                        <td>{{ $partner->name }}</td>
                        <td>{{ $partner->contact_name ?? '—' }}</td>
                        <td>{{ $partner->phone ?? '—' }}</td>
                        <td>{{ $partner->email ?? '—' }}</td>
                        <td>{{ $partner->products_count }}</td>
                        <td>
                            {!! $partner->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Ngừng hoạt động</span>' !!}
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-outline-primary" aria-label="Sửa đối tác">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa đối tác này?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" aria-label="Xóa đối tác">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Chưa có đối tác nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3">{{ $partners->links('pagination::bootstrap-5') }}</div>
</div>
@php($importType = 'partners')
@include('admin.partials.excel-import-modal')
@endsection
