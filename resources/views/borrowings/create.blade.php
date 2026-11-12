@extends('layouts.app')

@section('title', 'Form Permohonan Peminjaman Sarpras JTI')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb Formal -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small text-muted">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item">Layanan Sarpras</li>
                    <li class="breadcrumb-item active" aria-current="page">Formulir Peminjaman</li>
                </ol>
            </nav>

            <div class="card card-formal shadow-sm mb-4">
                <div class="p-4 border-bottom bg-light rounded-top">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold text-dark mb-1">Formulir Permohonan Izin Peminjaman</h4>
                            <p class="text-secondary small mb-0">
                                Jurusan Teknologi Informasi • Politeknik Negeri Jember
                            </p>
                        </div>
                        <span class="badge bg-white text-secondary border small py-2 px-3 fw-normal d-none d-md-inline">
                            <i class="bi bi-file-earmark-text text-primary me-1"></i> Standar Surat BEM Polije
                        </span>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('peminjaman.store') }}" method="POST" id="borrowForm">
                        @csrf

                        <!-- BAGIAN 1: IDENTITAS PEMOHON -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center gap-2">
                                <span class="badge bg-secondary bg-opacity-10 text-dark rounded-circle px-2 py-1">1</span>
                                <span>Identitas Pemohon / Peminjam</span>
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_peminjam" class="form-label small fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control @error('nama_peminjam') is-invalid @enderror" 
                                        value="{{ old('nama_peminjam', $user?->name) }}" required placeholder="Contoh: Keisya Hilmi Al-Rachman">
                                    @error('nama_peminjam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nim_nip" class="form-label small fw-semibold text-dark">NIM / NIP <span class="text-danger">*</span></label>
                                    <input type="text" name="nim_nip" id="nim_nip" class="form-control @error('nim_nip') is-invalid @enderror" 
                                        value="{{ old('nim_nip', $user?->nim_nip) }}" required placeholder="Contoh: E41220001 / A44231755">
                                    @error('nim_nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="prodi" class="form-label small fw-semibold text-dark">Program Studi <span class="text-danger">*</span></label>
                                    <select name="prodi" id="prodi" class="form-select @error('prodi') is-invalid @enderror" required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        <option value="D4 Teknik Informatika" {{ old('prodi', $user?->prodi) == 'D4 Teknik Informatika' ? 'selected' : '' }}>D4 Teknik Informatika</option>
                                        <option value="D3 Manajemen Informatika" {{ old('prodi', $user?->prodi) == 'D3 Manajemen Informatika' ? 'selected' : '' }}>D3 Manajemen Informatika</option>
                                        <option value="D4 Teknik Komputer" {{ old('prodi', $user?->prodi) == 'D4 Teknik Komputer' ? 'selected' : '' }}>D4 Teknik Komputer</option>
                                        <option value="D4 Bisnis Digital" {{ old('prodi', $user?->prodi) == 'D4 Bisnis Digital' ? 'selected' : '' }}>D4 Bisnis Digital</option>
                                        <option value="Ormawa / BEM / UKM Polije" {{ old('prodi', $user?->prodi) == 'Ormawa / BEM / UKM Polije' ? 'selected' : '' }}>Ormawa / BEM / UKM Polije</option>
                                        <option value="Dosen / Tendik JTI" {{ old('prodi', $user?->prodi) == 'Dosen / Tendik JTI' ? 'selected' : '' }}>Dosen / Tendik JTI</option>
                                    </select>
                                    @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="no_hp" class="form-label small fw-semibold text-dark">No. WhatsApp Aktif <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                        value="{{ old('no_hp', $user?->no_hp) }}" required placeholder="Contoh: 081234567890">
                                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label small fw-semibold text-dark">Email Mahasiswa / Polije</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                        value="{{ old('email', $user?->email) }}" placeholder="nama@student.polije.ac.id">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- BAGIAN 2: PEMILIHAN KATEGORI & SARANA PRASARANA -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center gap-2">
                                <span class="badge bg-secondary bg-opacity-10 text-dark rounded-circle px-2 py-1">2</span>
                                <span>Pemilihan Kategori & Sarana Prasarana</span>
                            </h6>

                            <div class="p-3 bg-light rounded border">
                                <div class="row g-3">
                                    <!-- Dropdown Kategori (Alat Musik / Syuting / PC) -->
                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label small fw-semibold text-dark">
                                            1. Pilih Kelompok Kategori <span class="text-danger">*</span>
                                        </label>
                                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Salah Satu Kategori --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id', request('category_id')) == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Dropdown Barang Otomatis Dinamis -->
                                    <div class="col-md-4">
                                        <label for="item_select" class="form-label small fw-semibold text-dark">
                                            2. Pilih Sarana Prasarana <span class="text-danger">*</span>
                                        </label>
                                        <select name="item_id[]" id="item_select" class="form-select @error('item_id') is-invalid @enderror" required disabled>
                                            <option value="">-- Pilih Kategori Terlebih Dahulu --</option>
                                        </select>
                                        <div id="itemLoadingText" class="form-text text-primary small d-none">
                                            <span class="spinner-border spinner-border-sm me-1"></span> Mengambil daftar inventaris...
                                        </div>
                                    </div>

                                    <!-- Jumlah Pinjam -->
                                    <div class="col-md-2">
                                        <label for="jumlah_input" class="form-label small fw-semibold text-dark">Jumlah <span class="text-danger">*</span></label>
                                        <input type="number" name="jumlah[]" id="jumlah_input" class="form-control" value="1" min="1" max="1" required>
                                        <div class="form-text small" id="stokHint">Maks: -</div>
                                    </div>
                                </div>

                                <!-- Box Rincian Barang Terpilih -->
                                <div id="selectedItemInfo" class="mt-3 p-3 bg-white rounded border d-none">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-dark" id="infoNamaBarang">-</div>
                                            <div class="text-muted small">
                                                Kode: <code id="infoKodeBarang">-</code> | Kondisi: <span id="infoKondisiBarang" class="badge bg-success small">-</span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-success" id="infoStokTersedia">- Unit Tersedia</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BAGIAN 3: JADWAL & NAMA KEGIATAN -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center gap-2">
                                <span class="badge bg-secondary bg-opacity-10 text-dark rounded-circle px-2 py-1">3</span>
                                <span>Waktu & Keperluan Kegiatan</span>
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tanggal_pinjam" class="form-label small fw-semibold text-dark">Tanggal Mulai Pinjam <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                        value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                                    @error('tanggal_pinjam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_kembali" class="form-label small fw-semibold text-dark">Tanggal Batas Pengembalian <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                                        value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+3 days'))) }}" min="{{ date('Y-m-d') }}" required>
                                    @error('tanggal_kembali') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label for="keperluan" class="form-label small fw-semibold text-dark">
                                        Nama Kegiatan / Keperluan Peminjaman <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="keperluan" id="keperluan" rows="3" class="form-control @error('keperluan') is-invalid @enderror" 
                                        required placeholder="Contoh: Talkshow Polije Berprestasi 2026 bertemakan 'From Campus to Champion: Membangun Generasi Unggul dan Berdaya Saing'">{{ old('keperluan') }}</textarea>
                                    <div class="form-text small">
                                        *Teks ini akan otomatis tercantum pada paragraf isi <strong>Surat Permohonan Izin Peminjaman Berkop Polije</strong>.
                                    </div>
                                    @error('keperluan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pakta Integritas / Pernyataan -->
                        <div class="p-3 bg-light rounded border mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="setujuSyarat" required>
                                <label class="form-check-label small text-secondary" for="setujuSyarat">
                                    Saya menyatakan bertanggung jawab penuh atas keutuhan, keamanan, dan kebersihan sarana prasarana laboratorium Jurusan Teknologi Informasi yang dipinjam, serta bersedia mengembalikan tepat waktu sesuai tanggal yang telah ditentukan.
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-polije px-4 py-2 shadow-sm" id="btnSubmit">
                                <i class="bi bi-send-check-fill me-1"></i> Ajukan & Terbitkan Surat Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('category_id');
    const itemSelect = document.getElementById('item_select');
    const jumlahInput = document.getElementById('jumlah_input');
    const stokHint = document.getElementById('stokHint');
    const loadingText = document.getElementById('itemLoadingText');
    const selectedItemInfo = document.getElementById('selectedItemInfo');
    const infoNama = document.getElementById('infoNamaBarang');
    const infoKode = document.getElementById('infoKodeBarang');
    const infoKondisi = document.getElementById('infoKondisiBarang');
    const infoStok = document.getElementById('infoStokTersedia');

    const preselectedItemId = "{{ request('item_id') }}";

    function loadItemsByCategory(categoryId, selectedId = null) {
        if (!categoryId) {
            itemSelect.innerHTML = '<option value="">-- Pilih Kategori Terlebih Dahulu --</option>';
            itemSelect.disabled = true;
            selectedItemInfo.classList.add('d-none');
            return;
        }

        loadingText.classList.remove('d-none');
        itemSelect.disabled = true;

        fetch(`{{ url('/api/kategori') }}/${categoryId}/items`)
            .then(res => res.json())
            .then(data => {
                loadingText.classList.add('d-none');
                itemSelect.disabled = false;

                if (data.length === 0) {
                    itemSelect.innerHTML = '<option value="">-- Tidak ada sarana prasarana tersedia di kategori ini --</option>';
                    selectedItemInfo.classList.add('d-none');
                    return;
                }

                let options = '<option value="">-- Pilih Sarana Prasarana --</option>';
                data.forEach(item => {
                    const isSelected = (selectedId && selectedId == item.id) ? 'selected' : '';
                    options += `<option value="${item.id}" ${isSelected} data-stok="${item.stok_tersedia}" data-kode="${item.kode_barang}" data-kondisi="${item.kondisi}" data-nama="${item.nama_barang}">
                        ${item.nama_barang} (${item.merk || '-'}) — Tersedia: ${item.stok_tersedia} Unit
                    </option>`;
                });
                itemSelect.innerHTML = options;

                if (selectedId) {
                    updateItemDetails();
                }
            })
            .catch(err => {
                loadingText.classList.add('d-none');
                itemSelect.innerHTML = '<option value="">Gagal memuat barang. Coba kembali.</option>';
            });
    }

    function updateItemDetails() {
        const selectedOpt = itemSelect.options[itemSelect.selectedIndex];
        if (selectedOpt && selectedOpt.value) {
            const stok = parseInt(selectedOpt.getAttribute('data-stok') || 1);
            const kode = selectedOpt.getAttribute('data-kode');
            const kondisi = selectedOpt.getAttribute('data-kondisi');
            const nama = selectedOpt.getAttribute('data-nama');

            jumlahInput.max = stok;
            stokHint.textContent = `Maks: ${stok} unit`;
            if (parseInt(jumlahInput.value) > stok) {
                jumlahInput.value = stok;
            }

            infoNama.textContent = nama;
            infoKode.textContent = kode;
            infoKondisi.textContent = kondisi;
            infoStok.textContent = `${stok} Unit Siap Pakai`;
            selectedItemInfo.classList.remove('d-none');
        } else {
            selectedItemInfo.classList.add('d-none');
            stokHint.textContent = 'Maks: -';
        }
    }

    categorySelect.addEventListener('change', function () {
        loadItemsByCategory(this.value);
    });

    itemSelect.addEventListener('change', updateItemDetails);

    if (categorySelect.value) {
        loadItemsByCategory(categorySelect.value, preselectedItemId);
    }

    const tglPinjam = document.getElementById('tanggal_pinjam');
    const tglKembali = document.getElementById('tanggal_kembali');

    tglPinjam.addEventListener('change', function () {
        tglKembali.min = this.value;
        if (tglKembali.value < this.value) {
            tglKembali.value = this.value;
        }
    });
});
</script>
@endpush
