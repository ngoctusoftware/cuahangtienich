@extends('admin.layouts.app')
@section('title', 'Nguoi dung')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <form class="d-flex gap-2" method="GET">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tim ten/email...">
        <button class="btn btn-outline-secondary">Tim</button>
    </form>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary text-nowrap ms-2"><i class="bi bi-plus-lg"></i> Them nguoi dung</a>
</div>

<div class="card shadow-sm">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Ten</th><th>Email</th><th>Vai tro</th><th>SDT</th><th>Trang thai</th><th></th></tr></thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-info text-dark">{{ $user->role->name ?? '-' }}</span></td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td>{!! $user->is_active ? '<span class="badge bg-success">Hoat dong</span>' : '<span class="badge bg-secondary">Khoa</span>' !!}</td>
                <td class="text-end">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoa nguoi dung nay?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
