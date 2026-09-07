@extends('admin.layouts.app')
@section('title', 'Nhóm khách hàng')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Nhóm khách hàng
        <a href="{{ route('admin.customer-groups.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm nhóm</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên nhóm</th><th>% Chiết khấu</th><th>Số khách</th><th></th></tr></thead>
            <tbody>
                @foreach($groups as $g)
                    <tr>
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
@endsection
