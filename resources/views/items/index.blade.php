@extends('layouts.app')

@section('title', 'Katalog Sarana Prasarana')

@push('styles')
<style>
    /* ─── HERO SECTION ─────────────────────────── */
    .hero-section {
        background: linear-gradient(135deg, #0a1f44 0%, #1a3a6e 60%, #1a56db 100%);
        color: #fff;
        padding: 48px 0 56px;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .hero-breadcrumb {
        font-size: 0.78rem;
        color: rgba(255,255,255,0.55);
        margin-bottom: 12px;
    }
    .hero-breadcrumb span { color: rgba(255,255,255,0.85); }
    .hero-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 2.1rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.5px;
        margin-bottom: 6px;
    }
    .hero-title em {
        font-style: normal;
        color: #facc15;
    }
    .hero-desc {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.65);
        max-width: 480px;
        margin-bottom: 24px;
        line-height: 1.6;
    }
    .hero-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .hero-stat {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 10px;
        padding: 10px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .hero-stat-num {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.3rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }
    .hero-stat-label {
        font-size: 0.72rem;
        color: rgba(255,255,255,0.6);
        font-weight: 500;
    }

    /* ─── SECTION KATEGORI ─────────────────────── */
    .section-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 4px;
    }
    .section-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.3rem;
        font-weight: 800;
        color: #0a1f44;
        margin-bottom: 0;
        letter-spacing: -0.3px;
    }

    /* ─── KARTU KATEGORI ───────────────────────── */
    .cat-card {
        background: #fff;
        border: 1px solid #dde3ed;
        border-radius: 16px;
        overflow: hidden;
        transition: box-shadow 0.22s, transform 0.22s;
    }
    .cat-card:hover {
        box-shadow: 0 10px 30px rgba(10,31,68,0.1);
        transform: translateY(-4px);
    }
    .cat-card-header {
        padding: 22px 22px 18px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .cat-icon-wrap {
        width: 52px; height: 52px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 1.4rem;
    }
    .cat-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.05rem;
        font-weight: 800;
        color: #0a1f44;
        margin-bottom: 2px;
    }
    .cat-location {
        font-size: 0.75rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 8px;
    }
    .cat-desc {
        font-size: 0.8rem;
        color: #94a3b8;
        line-height: 1.4;
    }
    .cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .cat-card-body {
        padding: 18px 22px;
    }

    /* Tombol pilih barang */
    .btn-pilih {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-radius: 9px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1.5px solid;
        background: #fff;
        cursor: pointer;
        transition: background 0.15s, color 0.15s;
    }

    /* Dropdown area */
    .dropdown-area {
        display: none;
        margin-top: 14px;
        animation: slideDown 0.2s ease;
    }
    .dropdown-area.show { display: block; }
    @keyframes slideDown {
        from { opacity:0; transform: translateY(-6px); }
        to   { opacity:1; transform: translateY(0); }
    }

    /* Info hasil */
    .item-info-box {
        display: none;
        margin-top: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
    }
    .item-info-box.show { display: block; }
    .item-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: #0a1f44;
        margin-bottom: 6px;
    }
</style>
@endpush

@section('content')

{{-- ═══ HERO ═══ --}}
<div class="hero-section">
    <div class="container">
        <div class="hero-breadcrumb">
            <i class="bi bi-house me-1"></i>
            Laboratorium Jurusan Teknologi Informasi &nbsp;•&nbsp;
            <span>Politeknik Negeri Jember</span>
        </div>

        <h1 class="hero-title">
            Peminjaman Sarana Prasarana<br>
            <em>Alat Musik, Alat Syuting, &amp; PC</em>
        </h1>
        <p class="hero-desc">
            Pilih kategori di bawah untuk melihat daftar barang dan ketersediaannya.
        </p>

        <div class="hero-stats">
            @foreach($categories as $cat)
                @php $tersedia = $cat->items->where('stok_tersedia', '>', 0)->count(); @endphp
                @php $label = match($cat->slug) {
                    'alat-musik'   => 'Studio Musik',
                    'alat-syuting' => 'Studio Multimedia',
                    'pc'           => 'Lab Komputer',
                    default        => $cat->nama,
                }; @endphp
                <div class="hero-stat">
                    <div>
                        <div class="hero-stat-num">{{ $tersedia }}</div>
                        <div class="hero-stat-label">{{ $label }}</div>
                    </div>
                    <div style="font-size:0.65rem; color:rgba(255,255,255,0.45); font-weight:600;">ALAT SIAP</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══ KATEGORI ═══ --}}
<div class="container py-5">

    <div class="d-flex align-items-end justify-content-between mb-4">
        <div>
            <div class="section-label">Katalog Sarana</div>
            <h2 class="section-title">Pilih Kelompok Sarana Prasarana</h2>
        </div>
        <span class="text-muted small fw-semibold">{{ $categories->count() }} Kategori Tersedia</span>
    </div>

    <div class="row g-4">
        @foreach($categories as $cat)
            @php
                $cfg = match($cat->slug) {
                    'alat-musik'   => [
                        'color'     => '#4f46e5',
                        'bg'        => '#eef2ff',
                        'icon'      => 'bi-music-note-beamed',
                        'location'  => 'Studio Musik Gedung TI Lt. 2',
                        'desc'      => 'Peralatan instrumen dan audio untuk studio musik/event',
                    ],
                    'alat-syuting' => [
                        'color'     => '#d97706',
                        'bg'        => '#fff7ed',
                        'icon'      => 'bi-camera-reels-fill',
                        'location'  => 'Studio Multimedia & Dry Cabinet',
                        'desc'      => 'Kamera, pencahayaan, dan audio untuk produksi multimedia',
                    ],
                    'pc'           => [
                        'color'     => '#0284c7',
                        'bg'        => '#f0f9ff',
                        'icon'      => 'bi-pc-display',
                        'location'  => 'Lab Komputer & RPL, Gedung TI',
                        'desc'      => 'Komputer, laptop, monitor, dan periferal lab',
                    ],
                    default        => [
                        'color'     => '#1e3a8a',
                        'bg'        => '#f1f5f9',
                        'icon'      => 'bi-box-seam',
                        'location'  => '-',
                        'desc'      => '',
                    ],
                };
                $tersedia = $cat->items->where('stok_tersedia', '>', 0)->count();
                $total    = $cat->items->count();
            @endphp

            <div class="col-md-4">
                <div class="cat-card h-100">
                    {{-- Header --}}
                    <div class="cat-card-header">
                        <div class="cat-icon-wrap" style="background:{{ $cfg['bg'] }}; color:{{ $cfg['color'] }};">
                            <i class="bi {{ $cfg['icon'] }}"></i>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div class="d-flex align-items-start justify-content-between gap-2">
                                <div class="cat-name">{{ $cat->nama }}</div>
                                @if($tersedia > 0)
                                    <span class="cat-badge" style="background:rgba(34,197,94,0.1); color:#15803d;">
                                        <span class="live-dot" style="width:6px;height:6px;"></span>
                                        {{ $tersedia }} Siap
                                    </span>
                                @else
                                    <span class="cat-badge" style="background:rgba(239,68,68,0.1); color:#dc2626;">
                                        Habis
                                    </span>
                                @endif
                            </div>
                            <div class="cat-location">
                                <i class="bi bi-geo-alt"></i> {{ $cfg['location'] }}
                            </div>
                            <div class="cat-desc">{{ $cfg['desc'] }}</div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="cat-card-body">

                        {{-- Tombol Buka --}}
                        <button type="button"
                                class="btn-pilih"
                                style="color:{{ $cfg['color'] }}; border-color:{{ $cfg['color'] }};"
                                onclick="toggleCat({{ $cat->id }}, this)">
                            <span id="btn-label-{{ $cat->id }}">Pilih Barang {{ $cat->nama }}</span>
                            <i class="bi bi-chevron-down" id="caret-{{ $cat->id }}"></i>
                        </button>

                        {{-- Dropdown --}}
                        <div class="dropdown-area" id="area-{{ $cat->id }}">
                            <select class="form-select mt-2"
                                    id="select-{{ $cat->id }}"
                                    onchange="pilihBarang({{ $cat->id }}, this.value)">
                                <option value="">— Pilih nama barang —</option>
                                @foreach($cat->items as $item)
                                    @php
                                        $ready = $item->stok_tersedia > 0;
                                        // Ambil lokasi dari borrowing aktif pertama yang terkait item ini
                                        $activeLokasi = '';
                                        $activePeminjam = '';
                                        $activeTglKembali = '';
                                        if (!$ready) {
                                            $activeDetail = $item->borrowingDetails
                                                ->filter(fn($d) => $d->borrowing && $d->borrowing->status === 'disetujui')
                                                ->first();
                                            if ($activeDetail && $activeDetail->borrowing) {
                                                $activeLokasi    = $activeDetail->borrowing->lokasi_penggunaan ?? '';
                                                $activePeminjam  = $activeDetail->borrowing->nama_peminjam ?? '';
                                                $activeTglKembali = $activeDetail->borrowing->tanggal_kembali
                                                    ? \Carbon\Carbon::parse($activeDetail->borrowing->tanggal_kembali)->translatedFormat('d F Y')
                                                    : '';
                                            }
                                        }
                                    @endphp
                                    <option value="{{ $item->id }}"
                                            data-nama="{{ $item->nama_barang }}"
                                            data-stok="{{ $item->stok_tersedia }}"
                                            data-ready="{{ $ready ? '1' : '0' }}"
                                            data-lokasi="{{ $activeLokasi }}"
                                            data-peminjam="{{ $activePeminjam }}"
                                            data-tglkembali="{{ $activeTglKembali }}">
                                        {{ $item->nama_barang }}
                                        ({{ $ready ? '✓ ' . $item->stok_tersedia . ' tersedia' : '✗ Dipinjam' }})
                                    </option>
                                @endforeach
                            </select>

                            {{-- Info barang terpilih --}}
                            <div class="item-info-box" id="info-{{ $cat->id }}">
                                <div class="item-name" id="iname-{{ $cat->id }}"></div>
                                <div id="istok-{{ $cat->id }}" class="mb-3"></div>
                                <a href="#" class="btn btn-accent w-100 fw-bold" id="ibtn-{{ $cat->id }}">
                                    Pinjam Barang Ini <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Link tracking --}}
    <div class="text-center mt-5 pt-2">
        <a href="{{ route('peminjaman.tracking') }}" class="text-muted small fw-semibold text-decoration-none">
            <i class="bi bi-search me-1"></i> Sudah mengajukan? Cek status surat peminjaman Anda
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function toggleCat(id, btn) {
        // Tutup semua yang lain
        document.querySelectorAll('.dropdown-area').forEach(el => {
            if (el.id !== 'area-' + id) el.classList.remove('show');
        });
        document.querySelectorAll('[id^="caret-"]').forEach(el => {
            if (el.id !== 'caret-' + id) el.className = 'bi bi-chevron-down';
        });

        const area  = document.getElementById('area-'  + id);
        const caret = document.getElementById('caret-' + id);
        const isOpen = area.classList.contains('show');

        if (isOpen) {
            area.classList.remove('show');
            caret.className = 'bi bi-chevron-down';
        } else {
            area.classList.add('show');
            caret.className = 'bi bi-chevron-up';
        }
    }

    function pilihBarang(catId, itemId) {
        const select = document.getElementById('select-' + catId);
        const info   = document.getElementById('info-'   + catId);
        const btn    = document.getElementById('ibtn-'   + catId);

        if (!itemId) { info.classList.remove('show'); return; }

        const opt        = select.options[select.selectedIndex];
        const nama       = opt.getAttribute('data-nama');
        const stok       = opt.getAttribute('data-stok');
        const ready      = opt.getAttribute('data-ready') === '1';
        const lokasi     = opt.getAttribute('data-lokasi') || '';
        const peminjam   = opt.getAttribute('data-peminjam') || '';
        const tglKembali = opt.getAttribute('data-tglkembali') || '';

        document.getElementById('iname-' + catId).textContent = nama;

        const stokEl = document.getElementById('istok-' + catId);
        if (ready) {
            stokEl.innerHTML = '<span class="badge fw-semibold" style="background:rgba(34,197,94,0.1);color:#15803d;padding:4px 10px;border-radius:6px;">✓ Tersedia ' + stok + ' unit</span>';
            btn.className = 'btn btn-accent w-100 fw-bold';
            btn.href = "{{ url('/peminjaman/ajukan') }}?category_id=" + catId + "&item_id=" + itemId;
            btn.innerHTML = 'Pinjam Barang Ini <i class="bi bi-arrow-right ms-1"></i>';
            btn.removeAttribute('disabled');
        } else {
            // Tampilkan badge "Sedang Dipinjam" + info lokasi jika ada
            let lokasiHtml = '';
            if (lokasi) {
                lokasiHtml = `
                    <div class="mt-2 p-2 rounded-3 d-flex align-items-start gap-2"
                         style="background:rgba(239,68,68,0.07); border:1px solid rgba(239,68,68,0.2); font-size:0.8rem;">
                        <i class="bi bi-geo-alt-fill text-danger mt-0" style="font-size:0.9rem; flex-shrink:0;"></i>
                        <div>
                            <div class="fw-semibold text-danger-emphasis">Sedang digunakan di:</div>
                            <div class="text-dark fw-bold">${lokasi}</div>
                            ${tglKembali ? `<div class="text-muted mt-1"><i class="bi bi-calendar-x me-1"></i>Estimasi kembali: <strong>${tglKembali}</strong></div>` : ''}
                        </div>
                    </div>`;
            } else {
                lokasiHtml = `<div class="mt-2 text-muted small"><i class="bi bi-info-circle me-1"></i>Lokasi penggunaan tidak dicatat.</div>`;
            }

            stokEl.innerHTML = `
                <span class="badge fw-semibold" style="background:rgba(239,68,68,0.1);color:#dc2626;padding:4px 10px;border-radius:6px;">
                    ✗ Stok Sedang Dipinjam
                </span>
                ${lokasiHtml}`;
            btn.className = 'btn btn-secondary w-100 fw-bold disabled mt-2';
            btn.removeAttribute('href');
            btn.innerHTML = 'Stok Tidak Tersedia';
        }

        info.classList.add('show');
    }
</script>
@endpush
