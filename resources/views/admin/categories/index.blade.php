@extends('admin.layouts.app')
@section('title', 'Danh mục')
@section('content')
@php($bulkDeleteFormId = 'bulk-delete-categories')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý danh mục
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-excel"></i> Xuất Excel
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.categories.export.current', request()->query()) }}"><i class="fas fa-list me-2"></i>Xuất danh sách hiện tại</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.categories.export.all') }}"><i class="fas fa-layer-group me-2"></i>Xuất tất cả danh sách</a></li>
                </ul>
            </div>
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal-categories"><i class="fas fa-file-import"></i> Import Excel</button>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm danh mục</a>
        </div>
    </div>
    @include('admin.partials.bulk-delete-toolbar', ['formId' => $bulkDeleteFormId, 'routeName' => 'admin.categories.bulk-destroy'])
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th><input type="checkbox" class="form-check-input" data-bulk-select="{{ $bulkDeleteFormId }}" aria-label="Chọn tất cả trên trang"></th><th>Tên</th><th>Danh mục cha</th><th>Thứ tự</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr>
                        <td><input type="checkbox" class="form-check-input" name="ids[]" value="{{ $cat->id }}" form="{{ $bulkDeleteFormId }}" data-bulk-delete-form="{{ $bulkDeleteFormId }}" aria-label="Chọn danh mục {{ $cat->translation()?->name }}"></td>
                        <td>{{ $cat->translation()?->name }}</td>
                        <td>{{ $cat->parent?->translation()?->name ?? '—' }}</td>
                        <td>{{ $cat->sort_order }}</td>
                        <td>{!! $cat->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá danh mục này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $categories->links() }}</div>
</div>
@php($importType = 'categories')
@include('admin.partials.excel-import-modal')
@endsection
