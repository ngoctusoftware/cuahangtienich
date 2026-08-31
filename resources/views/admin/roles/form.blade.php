@extends('admin.layouts.app')
@section('title', $role->exists ? 'Sua vai tro' : 'Them vai tro')
@section('content')
<form method="POST" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}" class="card shadow-sm p-4">
    @csrf
    @if ($role->exists) @method('PUT') @endif

    <div class="mb-3">
        <label class="form-label">Ten vai tro</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mo ta</label>
        <textarea name="description" class="form-control" rows="2">{{ old('description', $role->description) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label d-block">Danh sach quyen</label>
        @php $selected = old('permissions', $role->permissions?->pluck('id')->toArray() ?? []); @endphp
        @foreach ($permissions as $permission)
            <div class="form-check">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input" id="perm{{ $permission->id }}" @checked(in_array($permission->id, $selected))>
                <label class="form-check-label" for="perm{{ $permission->id }}">{{ $permission->name }} <code>{{ $permission->slug }}</code></label>
            </div>
        @endforeach
    </div>

    <button class="btn btn-primary">Luu</button>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Huy</a>
</form>
@endsection
