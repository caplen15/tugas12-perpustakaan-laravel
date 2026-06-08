<div class="card h-100 shadow-sm">
    <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div class="bg-secondary text-white rounded-3 d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
                <i class="bi bi-book-half fs-3"></i>
            </div>
            <span class="badge bg-primary text-white">{{ $buku->kategori }}</span>
        </div>

        <h5 class="card-title">{{ $buku->judul }}</h5>
        <p class="card-text text-muted mb-2">oleh {{ $buku->pengarang }}</p>

        <div class="mb-3">
            <div class="small text-muted">Harga</div>
            <div class="fw-semibold">{{ $buku->harga_formatted ?? 'Rp ' . number_format($buku->harga, 0, ',', '.') }}</div>
        </div>

        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }}">
                {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
            </span>
            <span class="badge bg-{{ $buku->stok > 0 ? 'info' : 'secondary' }}">Stok: {{ $buku->stok }}</span>
        </div>

        @if ($showActions)
            <div class="mt-auto d-flex gap-2">
                <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                    <i class="bi bi-eye"></i> Detail
                </a>
                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
            </div>
        @endif
    </div>
</div>