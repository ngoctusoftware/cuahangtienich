@extends('admin.layouts.app')
@section('title', 'Banner')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <span>Quản lý banner trang chủ</span>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm banner</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Ảnh</th><th>Tiêu đề</th><th>Liên kết</th><th>Thứ tự</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @forelse($banners as $banner)
                    <tr>
                        @php($translation = $banner->translation())
                        <td><img src="{{ $banner->image_url }}" alt="" width="120" height="55" style="object-fit:cover;border-radius:8px"></td>
                        <td>{!! $translation?->title ?? $banner->title !!}</td>
                        <td>{{ $translation?->cta_link ?? $banner->cta_link ?: '—' }}</td>
                        <td>{{ $banner->sort_order }}</td>
                        <td>{!! $banner->is_active ? '<span class="badge bg-success">Hiển thị</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá banner này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4">Chưa có banner.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $banners->links() }}</div>
</div>
@endsection
