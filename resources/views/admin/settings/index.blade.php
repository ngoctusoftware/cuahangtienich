@extends('admin.layouts.app')
@section('title', 'Cấu hình chung')
@section('content')
<div class="form-card">
    <h4 class="mb-4">Cấu hình chung website</h4>
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            @foreach($fields as $key => $label)
                <div class="col-md-6">
                    <label class="form-label">{{ $label }}</label>
                    <input type="text" name="{{ $key }}" class="form-control" value="{{ $values[$key] ?? '' }}">
                </div>
            @endforeach
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu thay đổi</button>
    </form>
</div>
@endsection
