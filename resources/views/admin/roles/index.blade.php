@extends('admin.layouts.app')
@section('title', 'Phan quyen / Vai tro')
@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Them vai tro</a>
</div>
<div class="card shadow-sm">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Ten vai tro</th><th>Slug</th><th>So nguoi dung</th><th></th></tr></thead>
        <tbody>
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td><code>{{ $role->slug }}</code></td>
                <td>{{ $role->users_count }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    @if (!in_array($role->slug, ['admin','customer']))
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoa vai tro nay?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $roles->links() }}</div>
@endsection
