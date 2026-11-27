@extends('layouts.app')

@section('title', 'Lacak Status Peminjaman Barang')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Lacak Status Peminjaman Barang</h3>
                <p class="text-muted">Masukkan Kode Transaksi (misal: <code>MMC-202611-XXXXX</code>), NIM, atau Nama Barang untuk melihat progres persetujuan dan status barang.</p>
            </div>

            <!-- Card Pencarian -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('peminjaman.tracking') }}" method="GET" id="trackingSearchForm">
                        <div class="position-relative">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white"><i class="bi bi-search text-primary"></i></span>
                                <input type="text"
                                       name="kode"
                                       id="trackingSearchInput"
                                       value="{{ request('kode') }}"
                                       class="form-control"
                                       placeholder="Masukkan Kode Transaksi, NIM, atau Nama Barang..."
                                       autocomplete="off"
                                       required>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
                                    Cari Status
                                </button>
                            </div>

                            <!-- Dropdown Rekomendasi Nama Barang -->
                            <div id="itemSuggestions"
                                 class="position-absolute w-100 bg-white border rounded-3 shadow-lg mt-1 d-none"
                                 style="z-index: 1050; max-height: 280px; overflow-y: auto;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(request()->filled('kode'))
                @if($borrowings->isNotEmpty())
                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <span class="text-muted small">
                            Ditemukan <strong>{{ $borrowings->count() }}</strong> data peminjaman untuk "<strong>{{ request('kode') }}</strong>"
                        </span>
                    </div>

                    @foreach($borrowings as $borrowing)
                        <div class="card shadow-sm border-0 border-top border-primary border-3 mb-4">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                    <div>
                                        <span class="text-muted small">Kode Transaksi:</span>
                                        <h5 class="fw-bold text-primary mb-0">{{ $borrowing->kode_transaksi }}</h5>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-muted small d-block">Status:</span>
                                        <span class="badge {{ $borrowing->status_badge }} fs-6">
                                            {{ $borrowing->status_label }}
                                        </span>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3 small">
                                    <div class="col-sm-6">
                                        <span class="text-muted">Nama Peminjam:</span>
                                        <div class="fw-bold">{{ $borrowing->nama_peminjam }} ({{ $borrowing->nim_nip }})</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted">Program Studi:</span>
                                        <div class="fw-bold">{{ $borrowing->prodi }}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted">Tanggal Pinjam:</span>
                                        <div class="fw-bold text-primary">{{ $borrowing->tanggal_pinjam->translatedFormat('d F Y') }}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted">Jam / Waktu:</span>
                                        <div class="fw-bold text-dark">{{ $borrowing->rentang_waktu }}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted">Estimasi Kembali:</span>
                                        <div class="fw-bold text-danger">{{ $borrowing->tanggal_kembali->translatedFormat('d F Y') }}</div>
                                    </div>
                                </div>

                                <h6 class="fw-bold border-top pt-3 mb-2">Barang yang Dipinjam:</h6>
                                <ul class="list-group list-group-flush mb-4">
                                    @foreach($borrowing->details as $d)
                                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $d->item->nama_barang }}</strong>
                                                <span class="badge bg-light text-dark border ms-2">{{ $d->item->category->nama }}</span>
                                            </div>
                                            <span class="badge bg-primary rounded-pill">{{ $d->jumlah }} unit</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('peminjaman.show', $borrowing->id) }}" class="btn btn-outline-primary w-50">
                                        <i class="bi bi-info-circle me-1"></i> Rincian Lengkap
                                    </a>
                                    <a href="{{ route('peminjaman.surat', $borrowing->id) }}" target="_blank" class="btn btn-primary w-50">
                                        <i class="bi bi-printer me-1"></i> Cetak Surat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning text-center p-4">
                        <i class="bi bi-search fs-2 d-block mb-2"></i>
                        <h5>Data Peminjaman Tidak Ditemukan</h5>
                        <p class="mb-0 small text-muted">Pastikan Kode Transaksi, NIM, atau Nama Barang yang Anda masukkan sudah benar.</p>
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = @json($items);
    const input = document.getElementById('trackingSearchInput');
    const dropdown = document.getElementById('itemSuggestions');
    const form = document.getElementById('trackingSearchForm');

    if (!input || !dropdown || !form) return;

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function renderSuggestions(keyword) {
        const q = keyword.trim().toLowerCase();
        if (!q) {
            dropdown.classList.add('d-none');
            dropdown.innerHTML = '';
            return;
        }

        const matched = items.filter(item => {
            const nama = (item.nama_barang || '').toLowerCase();
            const merk = (item.merk || '').toLowerCase();
            const kode = (item.kode_barang || '').toLowerCase();
            return nama.includes(q) || merk.includes(q) || kode.includes(q);
        });

        if (matched.length === 0) {
            dropdown.classList.add('d-none');
            dropdown.innerHTML = '';
            return;
        }

        dropdown.innerHTML = matched.map(item => {
            const catName = item.category ? item.category.nama : '';
            const merkText = item.merk ? ` • ${escapeHtml(item.merk)}` : '';
            return `
                <button type="button"
                        class="w-100 text-start btn btn-light bg-white border-0 border-bottom rounded-0 px-3 py-2 d-flex justify-content-between align-items-center suggestion-item"
                        data-nama="${escapeHtml(item.nama_barang)}">
                    <div>
                        <div class="fw-semibold text-dark">
                            <i class="bi bi-box-seam text-primary me-2"></i>${escapeHtml(item.nama_barang)}
                        </div>
                        <div class="small text-muted ps-4">
                            ${escapeHtml(catName)}${merkText}
                        </div>
                    </div>
                    <span class="badge bg-light text-secondary border ms-2">${item.stok_tersedia}/${item.stok_total} tersedia</span>
                </button>
            `;
        }).join('');

        dropdown.classList.remove('d-none');

        dropdown.querySelectorAll('.suggestion-item').forEach(btn => {
            btn.addEventListener('mousedown', function (e) {
                e.preventDefault();
                input.value = this.getAttribute('data-nama');
                dropdown.classList.add('d-none');
                form.submit();
            });
        });
    }

    input.addEventListener('input', function () {
        renderSuggestions(this.value);
    });

    input.addEventListener('focus', function () {
        if (this.value.trim().length > 0) {
            renderSuggestions(this.value);
        }
    });

    document.addEventListener('click', function (e) {
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('d-none');
        }
    });
});
</script>
@endpush

