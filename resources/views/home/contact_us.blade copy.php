<script>
    document.getElementById('consultForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const status = document.getElementById('statusMsg');
        status.textContent = 'Đã gửi đăng ký thành công! Chúng tôi sẽ liên hệ sớm nhất.';
        this.reset();
    });
</script>

<div class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="contact-info-panel">
                            <h2>Thông tin liên hệ</h2>
                            <p>Để lại thông tin, đội ngũ Happy Home Kindergarten sẽ liên hệ tư vấn lộ trình học phù hợp
                                nhất
                                cho bé.</p>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.36 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
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
                            <h1>Đăng ký tư vấn</h1>
                            <form id="consultForm">
                                <div class="field">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="8" r="4" />
                                        <path d="M4 21v-1a7 7 0 0 1 7-7h2a7 7 0 0 1 7 7v1" />
                                    </svg>
                                    <input type="text" name="parent_name" placeholder="Họ và tên phụ huynh *" required>
                                </div>

                                <div class="field">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.36 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                    <input type="tel" name="phone" placeholder="Số điện thoại *" required>
                                </div>

                                <div class="field">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M8 14s1.5 2 4 2 4-2 4-2" />
                                        <line x1="9" y1="9" x2="9.01" y2="9" />
                                        <line x1="15" y1="9" x2="15.01" y2="9" />
                                    </svg>
                                    <input type="text" name="child_name" placeholder="Họ và tên bé">
                                </div>

                                <div class="field">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16v16H4z" opacity="0" />
                                        <path d="M22 6l-10 7L2 6" />
                                        <rect x="2" y="4" width="20" height="16" rx="2" />
                                    </svg>
                                    <input type="email" name="email" placeholder="Email">
                                </div>

                                <div class="field">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                    </svg>
                                    <textarea name="message" placeholder="Lời nhắn"></textarea>
                                </div>

                                <button type="submit" class="btn-submit">Gửi đăng ký</button>
                                <div class="status-msg" id="statusMsg"></div>
                            </form>
                            <div class="divider">Hoặc</div>
                            <button type="button" class="btn-call" onclick="window.location.href='tel:0969702893'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.36 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                                Gọi ngay tư vấn
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>