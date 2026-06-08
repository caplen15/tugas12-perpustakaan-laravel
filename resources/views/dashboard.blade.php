@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Dashboard Perpustakaan</h1>
        <p class="text-muted">Ringkasan statistik buku dan anggota terbaru.</p>
    </div>
    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
        <i class="bi bi-house-door"></i> Menu Utama
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-primary rounded-pill me-3"><i class="bi bi-journal-bookmark"></i></span>
                    <div>
                        <h6 class="mb-0">Total Buku</h6>
                        <small class="text-muted">Koleksi perpustakaan</small>
                    </div>
                </div>
                <h2 class="card-title">{{ $totalBuku }}</h2>
                <div class="text-success">Tersedia: {{ $bukuTersedia }}</div>
                <div class="text-danger">Habis: {{ $bukuHabis }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-success rounded-pill me-3"><i class="bi bi-people-fill"></i></span>
                    <div>
                        <h6 class="mb-0">Total Anggota</h6>
                        <small class="text-muted">Data anggota aktif dan nonaktif</small>
                    </div>
                </div>
                <h2 class="card-title">{{ $totalAnggota }}</h2>
                <div class="text-success">Aktif: {{ $anggotaAktif }}</div>
                <div class="text-secondary">Nonaktif: {{ $anggotaNonaktif }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-info h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-info rounded-pill me-3"><i class="bi bi-link-45deg"></i></span>
                    <div>
                        <h6 class="mb-0">Quick Links</h6>
                        <small class="text-muted">Akses cepat ke menu utama</small>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ url('/') }}" class="list-group-item list-group-item-action">Home</a>
                    <a href="{{ route('buku.index') }}" class="list-group-item list-group-item-action">Data Buku</a>
                    <a href="{{ route('anggota.index') }}" class="list-group-item list-group-item-action">Data Anggota</a>
                    <a href="#" class="list-group-item list-group-item-action">Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">5 Buku Terbaru</h5>
                <a href="{{ route('buku.index') }}" class="small">Lihat semua</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse ($bukuTerbaru as $buku)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $buku->judul }}</strong>
                                    <div class="text-muted small">{{ $buku->kategori }} • Stok: {{ $buku->stok }}</div>
                                </div>
                                <span class="badge bg-secondary align-self-start">{{ $buku->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-muted">Belum ada data buku.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">5 Anggota Terbaru</h5>
                <a href="{{ route('anggota.index') }}" class="small">Lihat semua</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse ($anggotaTerbaru as $anggota)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $anggota->nama }}</strong>
                                    <div class="text-muted small">{{ $anggota->email }}</div>
                                </div>
                                <span class="badge bg-{{ $anggota->status === 'Aktif' ? 'success' : 'secondary' }} align-self-start">{{ $anggota->status }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-muted">Belum ada anggota baru.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
