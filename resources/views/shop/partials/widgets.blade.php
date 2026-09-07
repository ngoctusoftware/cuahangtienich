{{-- Widget nổi Zalo / Facebook Messenger / Điện thoại (giống góc phải ảnh mẫu 1) --}}
<div class="floating-widgets">
    <a href="https://zalo.me/{{ $settings['zalo_phone'] ?? '' }}" target="_blank" class="fw-btn fw-zalo" title="Chat Zalo">
        <i class="fa-solid fa-comment-dots"></i>
    </a>
    <a href="https://m.me/{{ $settings['fb_page'] ?? '' }}" target="_blank" class="fw-btn fw-messenger" title="Facebook Messenger">
        <i class="fa-brands fa-facebook-messenger"></i>
    </a>
    <a href="tel:{{ $settings['hotline'] ?? '' }}" class="fw-btn fw-phone" title="Gọi điện">
        <i class="fa-solid fa-phone"></i>
    </a>
</div>
