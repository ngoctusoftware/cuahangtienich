@extends('admin.layouts.app')
@section('title', 'San pham')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <form class="d-flex gap-2" method="GET">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tim san pham...">
        <button class="btn btn-outline-secondary">Tim</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary text-nowrap ms-2"><i class="bi bi-plus-lg"></i> Them san pham</a>
</div>

<div class="card shadow-sm">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Anh</th><th>Ten</th><th>Danh muc</th><th>Gia</th><th>Ton kho</th><th>Trang thai</th><th></th></tr></thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>
                    @if ($product->thumbnail)
                        <img src="{{ asset('storage/'.$product->thumbnail) }}" width="50" height="50" style="object-fit:cover" class="rounded">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:50px;height:50px;"><i class="bi bi-image text-muted"></i></div>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ number_format($product->price) }}₫</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if ($product->is_active)
                        <span class="badge bg-success">Dang ban</span>
                    @else
                        <span class="badge bg-secondary">An</span>
                    @endif
                </td>
                <td class="text-end">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoa san pham nay?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
