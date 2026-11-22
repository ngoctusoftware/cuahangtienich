@extends('admin.layouts.app')
@section('title', $partner->exists ? 'Sửa đối tác' : 'Thêm đối tác')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $partner->exists ? 'Sửa đối tác' : 'Thêm đối tác' }}</h4>
    <form action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}" method="POST">
        @csrf
        @if($partner->exists)
            @method('PUT')
        @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label for="partner-name" class="form-label">Tên đối tác <span class="text-danger">*</span></label>
                <input id="partner-name" type="text" name="name" class="form-control" value="{{ old('name', $partner->name) }}" required>
            </div>
            <div class="col-md-6">
                <label for="partner-zalo-telegram-link" class="form-label">Link Zalo/ Telegrams</label>
                <input id="partner-zalo-telegram-link" type="text" name="zalo_telegram_link" class="form-control" value="{{ old('zalo_telegram_link', $partner->zalo_telegram_link) }}">
            </div>
            <div class="col-md-6">
                <label for="partner-contact-name" class="form-label">Người liên hệ Zalo</label>
                <input id="partner-contact-name" type="text" name="contact_name" class="form-control" value="{{ old('contact_name', $partner->contact_name) }}">
            </div>
            <div class="col-md-6">
                <label for="partner-telegram-support-link" class="form-label">Link hỗ trợ Tele</label>
                <input id="partner-telegram-support-link" type="text" name="telegram_support_link" class="form-control" value="{{ old('telegram_support_link', $partner->telegram_support_link) }}">
            </div>
            <div class="col-md-6">
                <label for="partner-phone" class="form-label">Điện thoại</label>
                <input id="partner-phone" type="text" name="phone" class="form-control" value="{{ old('phone', $partner->phone) }}">
            </div>
            <div class="col-md-6">
                <label for="partner-email" class="form-label">Email</label>
                <input id="partner-email" type="email" name="email" class="form-control" value="{{ old('email', $partner->email) }}">
            </div>
            <div class="col-12">
                <label for="partner-address" class="form-label">Địa chỉ</label>
                <textarea id="partner-address" name="address" class="form-control" rows="2">{{ old('address', $partner->address) }}</textarea>
            </div>
            <div class="col-12">
                <label for="partner-notes" class="form-label">Ghi chú</label>
                <textarea id="partner-notes" name="notes" class="form-control" rows="3">{{ old('notes', $partner->notes) }}</textarea>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="partner-active"
                        {{ old('is_active', $partner->is_active || !$partner->exists) ? 'checked' : '' }}>
                    <label class="form-check-label" for="partner-active">Đang hoạt động</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu đối tác</button>
        <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary mt-4">Quay lại</a>
    </form>
</div>
@endsection
