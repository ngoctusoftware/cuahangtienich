<form id="{{ $formId }}" action="{{ route($routeName) }}" method="POST" class="bulk-delete-toolbar d-flex align-items-center gap-2 px-3 py-2 js-bulk-delete-form" data-confirm="Bạn có chắc muốn xóa các mục đã chọn không?">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger btn-sm">
        <i class="fas fa-trash"></i> Xóa đã chọn
    </button>
    <span class="small text-muted" data-selection-count>Chưa chọn mục nào</span>
</form>

@once
    @push('scripts')
        <script>
            document.querySelectorAll('.js-bulk-delete-form').forEach(function (form) {
                const checkboxes = document.querySelectorAll('[data-bulk-delete-form="' + form.id + '"]');
                const selectAll = document.querySelector('[data-bulk-select="' + form.id + '"]');
                const submitButton = form.querySelector('button[type="submit"]');
                const selectionCount = form.querySelector('[data-selection-count]');

                function updateSelection() {
                    const selectedCount = Array.from(checkboxes).filter(function (checkbox) {
                        return checkbox.checked;
                    }).length;

                    submitButton.disabled = selectedCount === 0;
                    selectionCount.textContent = selectedCount
                        ? 'Đã chọn ' + selectedCount + ' mục'
                        : 'Chưa chọn mục nào';

                    if (selectAll) {
                        selectAll.checked = checkboxes.length > 0 && selectedCount === checkboxes.length;
                        selectAll.indeterminate = selectedCount > 0 && selectedCount < checkboxes.length;
                    }
                }

                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', updateSelection);
                });

                if (selectAll) {
                    selectAll.addEventListener('change', function () {
                        checkboxes.forEach(function (checkbox) {
                            checkbox.checked = selectAll.checked;
                        });
                        updateSelection();
                    });
                }

                form.addEventListener('submit', function (event) {
                    if (!window.confirm(form.dataset.confirm)) {
                        event.preventDefault();
                    }
                });

                updateSelection();
            });
        </script>
    @endpush
@endonce
