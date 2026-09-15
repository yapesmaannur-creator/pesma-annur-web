<!-- Default Global Modal Template (Bootstrap 5) -->
<div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light bg-opacity-50">
                <h5 class="modal-title d-flex align-items-center" id="globalModalLabel">
                    <iconify-icon icon="solar:info-circle-bold-duotone" class="text-primary fs-22 me-2"></iconify-icon>
                    <span id="globalModalTitle">Informasi</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="globalModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light bg-opacity-50">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="globalModalAction">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
