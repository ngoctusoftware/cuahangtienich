@extends('admin.layouts.app')
@section('title', $category->exists ? 'Sua danh muc' : 'Them danh muc')
@section('content')
<form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="card shadow-sm p-4">
    @csrf
    @if ($category->exists) @method('PUT') @endif
    <div class="mb-3">
        <label class="form-label">Ten danh muc</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mo ta</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $category->is_active ?? true))>
        <label class="form-check-label" for="is_active">Hien thi</label>
    </div>
    <button class="btn btn-primary">Luu</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Huy</a>
</form>
@endsection
