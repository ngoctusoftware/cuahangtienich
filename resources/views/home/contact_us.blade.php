<div class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="contact-info-panel">
                            <h2>{{ __('storefront.home.contact_title') }}</h2>
                            <p>{{ __('storefront.home.contact_description') }}</p>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.36 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                </div>
                                <span>0969702893</span>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16v16H4z" opacity="0" />
                                        <path d="M22 6l-10 7L2 6" />
                                        <rect x="2" y="4" width="20" height="16" rx="2" />
                                    </svg>
                                </div>
                                <span>ntnnhp@badinhedu.vn</span>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                </div>
                                <span>Số 3, ngõ 34 Giảng Văn Minh, Đội Cấn, Ba Đình, Hà Nội</span>
                            </div>
                        </div>

                        <div class="contact-form-panel">
                            <h1>{{ __('storefront.home.consultation_title') }}</h1>
                            <form id="consultForm">
                                <div class="field">                                    
                                    <input type="text" name="parent_name" placeholder="{{ __('storefront.home.parent_name') }}" required>
                                </div>
                                <div class="field">                                    
                                    <input type="tel" name="phone" placeholder="{{ __('storefront.home.phone') }}" required>
                                </div>
                                <div class="field">                                    
                                    <input type="text" name="child_name" placeholder="{{ __('storefront.home.child_name') }}">
                                </div>

                                <div class="field">                                    
                                    <input type="email" name="email" placeholder="{{ __('storefront.home.email') }}">
                                </div>

                                <div class="field">                                    
                                    <textarea name="message" placeholder="{{ __('storefront.home.message') }}"></textarea>
                                </div>

                                <button type="submit" class="btn-submit">{{ __('storefront.home.send_request') }}</button>
                                <div class="status-msg" id="statusMsg"></div>
                            </form>
                            <div class="divider">{{ __('storefront.home.or') }}</div>
                            <button type="button" class="btn-call" onclick="window.location.href='tel:0969702893'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.36 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                                {{ __('storefront.home.call_consultation') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const consultForm = document.getElementById('consultForm');
        if (!consultForm) return; // an toàn: tránh lỗi null nếu form chưa render / bị xóa

        consultForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const status = document.getElementById('statusMsg');
            if (status) {
                status.textContent = @json(__('storefront.home.request_sent'));
            }
            this.reset();
        });
    });
</script>
@endpush