@extends('admin.layouts.app')
@section('title', 'Nhóm khách hàng')
@section('content')
@php($bulkDeleteFormId = 'bulk-delete-customer-groups')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Nhóm khách hàng
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal-customer-groups"><i class="fas fa-file-import"></i> Import Excel</button>
            <a href="{{ route('admin.customer-groups.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm nhóm</a>
        </div>
    </div>
    @include('admin.partials.bulk-delete-toolbar', ['formId' => $bulkDeleteFormId, 'routeName' => 'admin.customer-groups.bulk-destroy'])
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th><input type="checkbox" class="form-check-input" data-bulk-select="{{ $bulkDeleteFormId }}" aria-label="Chọn tất cả trên trang"></th><th>Tên nhóm</th><th>% Chiết khấu</th><th>Số khách</th><th></th></tr></thead>
            <tbody>
                @foreach($groups as $g)
                    <tr>
                        <td><input type="checkbox" class="form-check-input" name="ids[]" value="{{ $g->id }}" form="{{ $bulkDeleteFormId }}" data-bulk-delete-form="{{ $bulkDeleteFormId }}" aria-label="Chọn nhóm {{ $g->name }}"></td>
                        <td>{{ $g->name }}</td>
                        <td>{{ $g->discount_percent }}%</td>
                        <td>{{ $g->customers_count }}</td>
                        <td>
                            <a href="{{ route('admin.customer-groups.edit', $g) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.customer-groups.destroy', $g) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá nhóm này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@php($importType = 'customer-groups')
@include('admin.partials.excel-import-modal')
@endsection
