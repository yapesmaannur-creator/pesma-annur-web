<li class="dd-item" data-id="{{ $item->id }}">
    <div class="dd-handle">
        <iconify-icon icon="solar:hamburger-menu-linear" class="me-2 text-muted fs-16"></iconify-icon>
        <span>{{ $item->title }}</span> 
        <span class="text-muted ms-2 fs-12 fw-normal">( {{ $item->url }} )</span>
    </div>
    
    <div class="item-actions">
        <!-- Edit Button -->
        <button type="button" class="btn btn-sm btn-soft-primary px-2 py-0 edit-item-btn" 
                data-title="{{ $item->title }}"
                data-url="{{ $item->url }}"
                data-action="{{ route('admin.menus.items.update', $item->id) }}"
                title="Edit Tautan">
            <iconify-icon icon="solar:pen-bold-duotone" class="fs-14"></iconify-icon>
        </button>
        
        <!-- Delete Button -->
        <form action="{{ route('admin.menus.items.destroy', $item->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-soft-danger px-2 py-0" title="Hapus Tautan" onclick="return confirm('Yakin ingin menghapus tautan ini? (Sub-item juga akan terhapus)')">
                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-14"></iconify-icon>
            </button>
        </form>
    </div>

    @if($item->children->isNotEmpty())
        <ol class="dd-list">
            @foreach($item->children as $child)
                @include('admin.menus.partials.item', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>
