{{-- Widget nổi: Zalo, Messenger, Điện thoại --}}
<div class="floating-widgets">
    <a href="{{ $setting('zalo_link', 'https://zalo.me/') }}" target="_blank" class="widget-btn widget-zalo" title="Chat Zalo">
        <i class="fas fa-comment-dots"></i>
    </a>
    <a href="{{ $setting('messenger_link', 'https://m.me/') }}" target="_blank" class="widget-btn widget-messenger" title="Chat Messenger">
        <i class="fab fa-facebook-messenger"></i>
    </a>
    <a href="tel:{{ $setting('hotline', '0812119111') }}" class="widget-btn widget-phone" title="Gọi điện">
        <i class="fas fa-phone-alt"></i>
    </a>
</div>
