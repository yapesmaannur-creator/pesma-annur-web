@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        <div class="d-flex align-items-center">
            <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-24 me-2"></iconify-icon>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <div class="d-flex align-items-center">
            <iconify-icon icon="solar:danger-triangle-bold-duotone" class="fs-24 me-2"></iconify-icon>
            <div>{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <div class="d-flex align-items-start">
            <iconify-icon icon="solar:danger-circle-bold-duotone" class="fs-24 me-2 mt-1"></iconify-icon>
            <div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
