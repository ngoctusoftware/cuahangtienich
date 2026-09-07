@extends('admin.layouts.app')
@section('title', $group->exists ? 'Sửa nhóm' : 'Thêm nhóm')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $group->exists ? 'Sửa nhóm khách hàng' : 'Thêm nhóm khách hàng' }}</h4>
    <form action="{{ $group->exists ? route('admin.customer-groups.update', $group) : route('admin.customer-groups.store') }}" method="POST">
        @csrf
        @if($group->exists) @method('PUT') @endif
        <div class="mb-3">
            <label class="form-label">Tên nhóm</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $group->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">% Chiết khấu</label>
            <input type="number" step="0.01" name="discount_percent" class="form-control" value="{{ old('discount_percent', $group->discount_percent) }}">
        </div>
        <button class="btn btn-admin-primary">Lưu</button>
    </form>
</div>
@endsection
