@extends('admin.layouts.app')
@section('title', 'Danh muc')
@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Them danh muc</a>
</div>
<div class="card shadow-sm">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Ten</th><th>Slug</th><th>Trang thai</th><th></th></tr></thead>
        <tbody>
        @foreach ($categories as $cat)
            <tr>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->slug }}</td>
                <td>{!! $cat->is_active ? '<span class="badge bg-success">Hien</span>' : '<span class="badge bg-secondary">An</span>' !!}</td>
                <td class="text-end">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoa danh muc nay?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $categories->links() }}</div>
@endsection
