@extends('admin.layouts.app')
@section('title', 'Ngôn ngữ')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý ngôn ngữ
        <a href="{{ route('admin.languages.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm ngôn ngữ</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Mã</th><th>Tên</th><th>Mặc định</th><th>Kích hoạt</th><th>Thứ tự</th><th></th></tr></thead>
            <tbody>
                @foreach($languages as $lang)
                    <tr>
                        <td>{{ $lang->code }}</td>
                        <td>{{ $lang->name }}</td>
                        <td>{!! $lang->is_default ? '<span class="badge bg-success">Có</span>' : '' !!}</td>
                        <td>{!! $lang->is_active ? '<span class="badge bg-info">Bật</span>' : '<span class="badge bg-secondary">Tắt</span>' !!}</td>
                        <td>{{ $lang->sort_order }}</td>
                        <td>
                            <a href="{{ route('admin.languages.edit', $lang) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.languages.destroy', $lang) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá ngôn ngữ này?')">
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
