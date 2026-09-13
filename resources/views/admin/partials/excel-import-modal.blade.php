@php($modalId = 'importExcelModal-'.$importType)
<div class="modal fade excel-import-modal" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="js-excel-import-form" action="{{ route('admin.'.$importType.'.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <div class="excel-import-heading">
                        <span class="excel-import-icon"><i class="fas fa-file-excel"></i></span>
                        <div>
                            {{-- <span class="excel-import-eyebrow">Dữ liệu quản trị</span> --}}
                            <h5 class="modal-title">Import Excel</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="excel-import-intro">
                        <h6>Nhập dữ liệu nhanh chóng</h6>
                        <p>Tải file theo đúng cấu trúc mẫu để hệ thống xử lý chính xác.</p>
                    </div>
                    <div class="excel-file-field">
                        <label for="{{ $modalId }}-file" class="excel-dropzone">
                            <span class="excel-upload-icon"><i class="fas fa-cloud-arrow-up"></i></span>
                            <span class="excel-dropzone-title">Chọn file để tải lên</span>
                            <span class="excel-dropzone-hint">Kéo thả hoặc nhấn để duyệt file</span>
                            <span class="excel-file-name">Chưa chọn file</span>
                            <input id="{{ $modalId }}-file" type="file" name="file" accept=".xls,.csv" required>
                        </label>
                        <div class="excel-format-note"><i class="fas fa-circle-info"></i> Hỗ trợ Excel <strong>.xls</strong> và <strong>.csv</strong>, tối đa 10 MB.</div>
                    </div>
                    <div class="js-import-error alert alert-danger d-none mb-0"></div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.'.$importType.'.import-template') }}" class="btn excel-template-btn"><i class="fas fa-download"></i> Tải file mẫu</a>
                    <div class="excel-modal-actions">
                        <button type="submit" class="btn btn-admin-primary excel-submit-btn"><i class="fas fa-file-import"></i> Bắt đầu import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
document.querySelectorAll('.js-excel-import-form').forEach(function (form) {
    const fileInput = form.querySelector('input[type="file"]');
    const fileName = form.querySelector('.excel-file-name');
    fileInput.addEventListener('change', function () {
        fileName.textContent = fileInput.files[0]?.name || 'Chưa chọn file';
        fileName.classList.toggle('has-file', fileInput.files.length > 0);
    });

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        const button = form.querySelector('button[type="submit"]');
        const error = form.querySelector('.js-import-error');
        button.disabled = true;
        error.classList.add('d-none');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!response.ok) {
                const payload = await response.json();
                error.textContent = Object.values(payload.errors || {}).flat().join(' ');
                error.classList.remove('d-none');
                button.disabled = false;
                return;
            }
            bootstrap.Modal.getOrCreateInstance(form.closest('.modal')).hide();
            window.location.reload();
        } catch (exception) {
            error.textContent = 'Không thể import file. Vui lòng kiểm tra lại file và thử lại.';
            error.classList.remove('d-none');
            button.disabled = false;
        }
    });
});
</script>
@endpush
@endonce