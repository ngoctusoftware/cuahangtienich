@extends('admin.layouts.app')
@section('title', 'Cảm nhận khách hàng')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <span>Quản lý cảm nhận khách hàng</span>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-admin-primary btn-sm"><i
                class="fas fa-plus"></i> Thêm cảm nhận</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Khách hàng</th>
                    <th>Nội dung</th>
                    <th>Đánh giá</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                @php($translation = $testimonial->translation())
                @php($imageName = $testimonial->image ? basename($testimonial->image) : null)
                @php($imagePath = $imageName && file_exists(public_path('images/' . $imageName)) ? $imageName : 'no_name.png')
                <tr>
                    <td>
                        <img src="{{ asset('images/' . $imagePath) }}" alt="{{ $translation?->title }}"
                            class="rounded-circle" width="44" height="44">
                    </td>
                    <td>
                        @if($translation?->title)
                            <strong>{{ $translation->title }}</strong>
                        @endif
                        @if($testimonial->key)
                            <div class="small text-muted">{{ $testimonial->key }}</div>
                        @endif
                    </td>
                    <td>
                        @if($translation?->body)
                            {{ \Illuminate\Support\Str::limit($translation->body, 90) }}
                        @endif
                    </td>
                    <td class="text-warning">
                        @if($testimonial->rating)
                            {{ str_repeat('★', $testimonial->rating) }}<span
                                class="text-muted">{{ str_repeat('★', 5 - $testimonial->rating) }}</span>
                        @endif
                    </td>
                    <td>{!! $testimonial->is_active ? '<span class="badge bg-success">Hiển thị</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}
                    </td>
                    <td>
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                            class="btn btn-sm btn-outline-primary" title="Sửa"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Xoá cảm nhận này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Xoá"><i
                                    class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Chưa có cảm nhận khách hàng.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $testimonials->links() }}</div>
</div>
@endsection