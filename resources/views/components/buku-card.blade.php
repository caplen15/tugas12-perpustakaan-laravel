<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 text-center">
                <i class="bi bi-book text-primary" style="font-size: 4rem;"></i>
                <div class="mt-2">
                    <span class="badge bg-{{ $buku->kategori == 'Programming' ? 'primary' : ($buku->kategori == 'Database' ? 'success' : ($buku->kategori == 'Web Design' ? 'info' : ($buku->kategori == 'Networking' ? 'warning' : 'danger'))) }}">
                        {{ $buku->kategori }}
                    </span>
                </div>
            </div>

            <div class="col-md-7">
                <h5 class="card-title">
                    <a href="{{ route('buku.show', $buku->id) }}" class="text-decoration-none">
                        {{ $buku->judul }}
                    </a>
                </h5>

                <p class="card-text text-muted mb-2">
                    <i class="bi bi-person"></i> {{ $buku->pengarang }} |
                    <i class="bi bi-building"></i> {{ $buku->penerbit }} |
                    <i class="bi bi-calendar"></i> {{ $buku->tahun_terbit }}
                </p>

                @if ($buku->isbn)
                <p class="card-text small text-muted mb-1">
                    <i class="bi bi-upc"></i> ISBN: {{ $buku->isbn }}
                </p>
                @endif

                @if ($buku->deskripsi)
                <p class="card-text">
                    {{ Str::limit($buku->deskripsi, 150) }}
                </p>
                @endif
            </div>

            <div class="col-md-3 text-end">
                <h4 class="text-primary mb-2">
                    {{ $buku->harga_format }}
                </h4>

                <div class="mb-3">
                    @if ($buku->stok > 0)
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle"></i> Tersedia
                    </span>
                    <div class="text-muted small mt-1">
                        Stok: {{ $buku->stok }} buku
                    </div>
                    @else
                    <span class="badge bg-danger">
                        <i class="bi bi-x-circle"></i> Habis
                    </span>
                    @endif
                </div>

                <div class="btn-group-vertical d-grid gap-2">
                    <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-info text-white">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    {{-- Delete Button dengan SweetAlert --}}
                    @if ($showActions)
                    <form action="{{ route('buku.destroy', $buku->id) }}"
                        method="POST"
                        class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger w-100 btn-delete"
                            data-judul="{{ $buku->judul }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>

                    @push('scripts')
                    <script>
                        // SweetAlert confirmation untuk delete
                        document.querySelectorAll('.btn-delete').forEach(button => {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();
                                const form = this.closest('form');
                                const judul = this.getAttribute('data-judul');

                                Swal.fire({
                                    title: 'Konfirmasi Hapus',
                                    text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        form.submit();
                                    }
                                });
                            });
                        });
                    </script>
                    @endpush
                </div>
                @endif
            </div>
        </div>
    </div>
</div>