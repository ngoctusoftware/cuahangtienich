@extends('admin.layouts.app')
@section('title', 'Sản phẩm')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <form class="d-flex gap-2" method="GET">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm sản phẩm..." value="{{ request('search') }}">
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Ảnh</th><th>Tên</th><th>Danh mục</th><th>Giá</th><th>Kho</th><th>Nổi bật</th><th>Bán chạy</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($products as $p)
                    <tr>
                        <td><img src="{{ $p->thumbnail ? asset('storage/'.$p->thumbnail) : asset('images/product-placeholder.jpg') }}" width="48" height="48" style="object-fit:cover;border-radius:6px"></td>
                        <td>{{ $p->translation()?->name }}</td>
                        <td>{{ $p->category->translation()?->name }}</td>
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
    <div class="p-3">{{ $products->links() }}</div>
</div>
@endsection
