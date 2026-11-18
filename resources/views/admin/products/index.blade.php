@extends('admin.layouts.app')
@section('title', 'Sản phẩm')
@section('content')
@php($bulkDeleteFormId = 'bulk-delete-products')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <form class="d-flex gap-2" method="GET">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm sản phẩm..." value="{{ request('search') }}">
        </form>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-excel"></i> Xuất Excel
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.products.export.current', request()->query()) }}"><i class="fas fa-list me-2"></i>Xuất danh sách hiện tại</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.products.export.all') }}"><i class="fas fa-layer-group me-2"></i>Xuất tất cả danh sách</a></li>
                </ul>
            </div>
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal-products"><i class="fas fa-file-import"></i> Import Excel</button>
            <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
        </div>
    </div>
    @include('admin.partials.bulk-delete-toolbar', ['formId' => $bulkDeleteFormId, 'routeName' => 'admin.products.bulk-destroy'])
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th><input type="checkbox" class="form-check-input" data-bulk-select="{{ $bulkDeleteFormId }}" aria-label="Chọn tất cả trên trang"></th><th>Ảnh</th><th>Tên</th><th>Danh mục</th><th>Đối tác</th><th>Giá</th><th>Kho</th><th>Nổi bật</th><th>Bán chạy</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($products as $p)
                    <tr>
                        <td><input type="checkbox" class="form-check-input" name="ids[]" value="{{ $p->id }}" form="{{ $bulkDeleteFormId }}" data-bulk-delete-form="{{ $bulkDeleteFormId }}" aria-label="Chọn sản phẩm {{ $p->translation()?->name }}"></td>
                        <td><img src="{{ $p->thumbnail_url }}" width="48" height="48" style="object-fit:cover;border-radius:6px"></td>
                        <td>{{ $p->translation()?->name }}</td>
                        <td>{{ $p->category->translation()?->name }}</td>
                        <td>{{ $p->partner?->name ?? '—' }}</td>
                        <td>{{ number_format($p->price) }}₫</td>
                        <td>{{ $p->stock }}</td>
                        <td>{!! $p->is_featured ? '<i class="fas fa-check text-success"></i>' : '' !!}</td>
                        <td>{!! $p->is_bestseller ? '<i class="fas fa-check text-success"></i>' : '' !!}</td>
                        <td>{!! $p->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá sản phẩm này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $products->links('pagination::bootstrap-5') }}</div>
</div>
@php($importType = 'products')
@include('admin.partials.excel-import-modal')
@endsection
