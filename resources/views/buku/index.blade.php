@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>
            <i class="bi bi-book"></i> Daftar Buku
        </h1>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('buku.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Export CSV
        </a>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Buku
        </a>
    </div>
</div>

{{-- Statistik Cards --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Tersedia</h6>
                        <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Habis</h6>
                        <h2 class="mb-0">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Kategori Cepat --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="card-title mb-3">
            <i class="bi bi-funnel"></i> Filter Kategori:
        </h6>
        <div class="btn-group flex-wrap" role="group">
            <a href="{{ route('buku.index') }}" class="btn btn-sm {{ !isset($kategori) ? 'btn-primary' : 'btn-outline-primary' }}">
                Semua
            </a>
            <a href="{{ route('buku.kategori', 'Programming') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Programming' ? 'btn-primary' : 'btn-outline-primary' }}">
                Programming
            </a>
            <a href="{{ route('buku.kategori', 'Database') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Database' ? 'btn-primary' : 'btn-outline-primary' }}">
                Database
            </a>
            <a href="{{ route('buku.kategori', 'Web Design' ?? 'Web Design') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Web Design' ? 'btn-primary' : 'btn-outline-primary' }}">
                Web Design
            </a>
            <a href="{{ route('buku.kategori', 'Networking') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Networking' ? 'btn-primary' : 'btn-outline-primary' }}">
                Networking
            </a>
            <a href="{{ route('buku.kategori', 'Data Science') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Data Science' ? 'btn-primary' : 'btn-outline-primary' }}">
                Data Science
            </a>
        </div>
    </div>
</div>

{{-- Pencarian Detail --}}
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('buku.search') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Keyword</label>
                <input
                    type="text"
                    name="keyword"
                    class="form-control"
                    placeholder="Cari judul, pengarang, penerbit"
                    value="{{ old('keyword', $keyword ?? '') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $filterKategori)
                    <option
                        value="{{ $filterKategori }}"
                        {{ old('kategori', $kategori ?? '') == $filterKategori ? 'selected' : '' }}>
                        {{ $filterKategori }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach ($tahunList as $filterTahun)
                    <option
                        value="{{ $filterTahun }}"
                        {{ old('tahun', $tahun ?? '') == $filterTahun ? 'selected' : '' }}>
                        {{ $filterTahun }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Ketersediaan</label>
                <select name="ketersediaan" class="form-select">
                    <option value="">Semua</option>
                    <option value="tersedia" {{ old('ketersediaan', $ketersediaan ?? '') == 'tersedia' ? 'selected' : '' }}>
                        Tersedia
                    </option>
                    <option value="habis" {{ old('ketersediaan', $ketersediaan ?? '') == 'habis' ? 'selected' : '' }}>
                        Habis
                    </option>
                </select>
            </div>
            <div class="col-md-2 d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Cari
                </button>
                <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tampilan Buku --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <input type="checkbox" id="select-all" class="form-check-input">
        <label for="select-all" class="ms-2">Pilih Semua</label>
    </div>

    <div>
        <button type="button" id="bulk-delete-btn" class="btn btn-danger">
            <i class="bi bi-trash"></i> Hapus Terpilih
        </button>
    </div>
</div>

<div class="buku-container">
    @forelse ($bukus as $buku)
    <x-buku-card :buku="$buku" />
    @empty
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Tidak ada data buku
        @isset($kategori)
        dengan kategori <strong>{{ $kategori }}</strong>
        @endisset
    </div>
    @endforelse
</div>

<form id="bulk-delete-form" action="{{ route('buku.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
</form>

{{-- Info Menampilkan Data --}}
@if ($bukus->count() > 0)
<div class="text-center mt-4">
    <p class="text-muted">
        Menampilkan {{ $bukus->count() }} buku
        @isset($kategori)
        dari kategori <strong>{{ $kategori }}</strong>
        @endisset
    </p>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Event delegation untuk SweetAlert confirmation delete
    document.addEventListener('click', function(e) {
        const button = e.target.closest('.btn-delete');
        if (!button) return;

        e.preventDefault();
        const form = button.closest('form');
        const judul = button.getAttribute('data-judul');

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
</script>
<script>
    // Select all checkbox behavior
    document.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'select-all') {
            document.querySelectorAll('input[name="buku_ids[]"]').forEach(cb => {
                cb.checked = e.target.checked;
            });
        }
    });

    document.getElementById('bulk-delete-btn').addEventListener('click', function(e) {
        const checked = Array.from(document.querySelectorAll('input[name="buku_ids[]"]:checked'));

        if (checked.length === 0) {
            Swal.fire({ icon: 'info', title: 'Tidak ada data', text: 'Pilih minimal satu buku.' });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus ${checked.length} buku terpilih?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('bulk-delete-form');
                checked.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'buku_ids[]';
                    input.value = cb.value;
                    form.appendChild(input);
                });
                form.submit();
            }
        });
    });
</script>
@endpush