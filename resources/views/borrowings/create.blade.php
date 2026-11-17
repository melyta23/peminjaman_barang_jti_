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
                                <span class="badge rounded-circle px-2 py-1" style="background: rgba(100, 116, 139, 0.15); color: #334155; font-size: 0.8rem;">1</span>
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

                                <div class="col-md-6">
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

                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label small fw-semibold text-dark">No. WhatsApp Aktif <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                        value="{{ old('no_hp', $user?->no_hp) }}" required placeholder="Contoh: 081234567890">
                                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>


                            </div>
                        </div>

                        <!-- BAGIAN 2: PEMILIHAN SARANA PRASARANA (BISA LEBIH DARI 1) -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <span class="badge rounded-circle px-2 py-1" style="background: rgba(100, 116, 139, 0.15); color: #334155; font-size: 0.8rem;">2</span>
                                    <span>Pemilihan Sarana Prasarana (Bisa Lebih Dari 1 Barang)</span>
                                </h6>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" id="btnTambahBarangAtas">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Barang Lain
                                </button>
                            </div>

                            <!-- Container Daftar Barang Dinamis -->
                            <div id="itemsContainer" class="d-flex flex-column gap-3">
                                <!-- Baris barang dimasukkan secara dinamis oleh JavaScript -->
                            </div>

                            <div class="mt-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                                <div class="text-muted small">
                                    <i class="bi bi-info-circle text-primary me-1"></i> Anda dapat menambahkan beberapa barang sekaligus dalam 1 surat permohonan.
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-semibold px-3" id="btnTambahBarangBawah">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Barang Lain
                                </button>
                            </div>
                        </div>

                        <!-- BAGIAN 3: JADWAL & NAMA KEGIATAN -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center gap-2">
                                <span class="badge rounded-circle px-2 py-1" style="background: rgba(100, 116, 139, 0.15); color: #334155; font-size: 0.8rem;">3</span>
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

                                <div class="col-md-6">
                                    <label for="jam_mulai" class="form-label small fw-semibold text-dark">Jam Mulai Pinjam / Kegiatan <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                        value="{{ old('jam_mulai', '07:00') }}" required>
                                    <div class="form-text small">Contoh: 07:00 WIB (Waktu mulai penggunaan)</div>
                                    @error('jam_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="jam_selesai" class="form-label small fw-semibold text-dark mb-0">Jam Selesai Pinjam / Kegiatan</label>
                                        <div class="form-check form-check-inline m-0">
                                            <input class="form-check-input" type="checkbox" id="sampaiSelesaiCheck" name="sampai_selesai" value="1" {{ old('sampai_selesai') ? 'checked' : '' }}>
                                            <label class="form-check-label small text-primary fw-semibold" for="sampaiSelesaiCheck" style="cursor: pointer;">
                                                <i class="bi bi-clock-history me-1"></i>Sampai Selesai
                                            </label>
                                        </div>
                                    </div>
                                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                        value="{{ old('jam_selesai', '16:00') }}">
                                    <div class="form-text small" id="jamSelesaiHint">Pilih jam atau centang <strong>"Sampai Selesai"</strong> jika waktu berakhir kondisional.</div>
                                    @error('jam_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label for="keperluan" class="form-label small fw-semibold text-dark">
                                        Nama Kegiatan / Keperluan Peminjaman <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="keperluan" id="keperluan" rows="3" class="form-control @error('keperluan') is-invalid @enderror" 
                                        required placeholder="Contoh: Talkshow Polije Berprestasi 2026 bertemakan 'From Campus to Campus: Membangun Generasi Unggul dan Berdaya Saing'">{{ old('keperluan') }}</textarea>
                                    <div class="form-text small">
                                        *Teks ini akan otomatis tercantum pada paragraf isi <strong>Surat Permohonan Izin Peminjaman Berkop Polije</strong>.
                                    </div>
                                    @error('keperluan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Lokasi Penggunaan --}}
                                <div class="col-12">
                                    <label for="lokasi_penggunaan" class="form-label small fw-semibold text-dark">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                        Lokasi / Tempat Penggunaan Barang <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="lokasi_penggunaan" id="lokasi_penggunaan"
                                        class="form-control @error('lokasi_penggunaan') is-invalid @enderror"
                                        value="{{ old('lokasi_penggunaan') }}"
                                        required
                                        placeholder="Contoh: Aula Polije Lt. 2, Lab Alat Musik JTI, Panggung Outdoor Polije, dll.">
                                    <div class="form-text small">
                                        <i class="bi bi-info-circle me-1"></i>Isi dengan lokasi spesifik tempat barang akan digunakan selama masa peminjaman.
                                    </div>
                                    @error('lokasi_penggunaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
    const categoriesData = @json($categories);
    const preselectedCatId = "{{ request('category_id') }}";
    const preselectedItemId = "{{ request('item_id') }}";
    const oldItemIds = @json(old('item_id', []));
    const oldJumlah = @json(old('jumlah', []));

    const itemsContainer = document.getElementById('itemsContainer');
    const btnTambahAtas = document.getElementById('btnTambahBarangAtas');
    const btnTambahBawah = document.getElementById('btnTambahBarangBawah');

    let rowCounter = 0;

    function createItemRow(initialCatId = '', initialItemId = '', initialQty = 1) {
        rowCounter++;
        const rowId = `item-row-${rowCounter}`;
        const rowEl = document.createElement('div');
        rowEl.className = 'item-row p-3 bg-light rounded border position-relative';
        rowEl.id = rowId;

        let catOptions = '<option value="">-- Pilih Salah Satu Kategori --</option>';
        categoriesData.forEach(c => {
            const isSel = (initialCatId && initialCatId == c.id) ? 'selected' : '';
            catOptions += `<option value="${c.id}" ${isSel}>${c.nama}</option>`;
        });

        rowEl.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge fw-semibold row-label" style="background: rgba(59, 110, 165, 0.12); color: #3b6ea5; border: 1px solid rgba(59, 110, 165, 0.25); font-size: 0.78rem; padding: 5px 12px; border-radius: 6px;">
                    <i class="bi bi-box-seam me-1"></i> Barang #1
                </span>
                <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none p-0 btn-remove-row d-none">
                    <i class="bi bi-trash3-fill me-1"></i> Hapus Barang
                </button>
            </div>
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-dark">1. Kelompok Kategori <span class="text-danger">*</span></label>
                    <select class="form-select select-category" required>
                        ${catOptions}
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-dark">2. Sarana Prasarana <span class="text-danger">*</span></label>
                    <select name="item_id[]" class="form-select select-item" required disabled>
                        <option value="">-- Pilih Kategori Terlebih Dahulu --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-dark">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah[]" class="form-control input-jumlah" value="${initialQty}" min="1" max="1" required>
                    <div class="form-text small hint-stok">Maks: -</div>
                </div>
            </div>
            <div class="info-barang mt-3 p-3 bg-white rounded border d-none">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-dark item-info-nama">-</div>
                        <div class="text-muted small">
                            Kode: <code class="item-info-kode">-</code> | Kondisi: <span class="badge small item-info-kondisi" style="background: rgba(34, 197, 94, 0.15); color: #15803d; border: 1px solid rgba(34, 197, 94, 0.3); font-weight: 600; font-size: 0.74rem;">-</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge item-info-stok" style="background: rgba(34, 197, 94, 0.15); color: #15803d; border: 1px solid rgba(34, 197, 94, 0.3); font-weight: 600; font-size: 0.74rem;">- Unit Tersedia</span>
                    </div>
                </div>
            </div>
        `;

        itemsContainer.appendChild(rowEl);
        setupRowEvents(rowEl, initialCatId, initialItemId);
        updateRowNumbers();
    }

    function setupRowEvents(rowEl, initialCatId, initialItemId) {
        const catSelect = rowEl.querySelector('.select-category');
        const itemSelect = rowEl.querySelector('.select-item');
        const jumlahInput = rowEl.querySelector('.input-jumlah');
        const hintStok = rowEl.querySelector('.hint-stok');
        const infoBox = rowEl.querySelector('.info-barang');
        const infoNama = rowEl.querySelector('.item-info-nama');
        const infoKode = rowEl.querySelector('.item-info-kode');
        const infoKondisi = rowEl.querySelector('.item-info-kondisi');
        const infoStok = rowEl.querySelector('.item-info-stok');
        const btnRemove = rowEl.querySelector('.btn-remove-row');

        btnRemove.addEventListener('click', function () {
            rowEl.remove();
            updateRowNumbers();
        });

        function populateItems(catId, selItemId = null) {
            if (!catId) {
                itemSelect.innerHTML = '<option value="">-- Pilih Kategori Terlebih Dahulu --</option>';
                itemSelect.disabled = true;
                infoBox.classList.add('d-none');
                hintStok.textContent = 'Maks: -';
                return;
            }

            const category = categoriesData.find(c => c.id == catId);
            const items = category ? (category.items || []) : [];

            if (items.length === 0) {
                itemSelect.innerHTML = '<option value="">-- Tidak ada inventaris di kategori ini --</option>';
                itemSelect.disabled = true;
                infoBox.classList.add('d-none');
                return;
            }

            let options = '<option value="">-- Pilih Sarana Prasarana --</option>';
            items.forEach(item => {
                const isSel = (selItemId && selItemId == item.id) ? 'selected' : '';
                const stokLabel = item.stok_tersedia > 0 ? `${item.stok_tersedia} Unit` : 'Habis';
                const disabledAttr = item.stok_tersedia <= 0 ? 'disabled' : '';
                options += `<option value="${item.id}" ${isSel} ${disabledAttr} data-stok="${item.stok_tersedia}" data-kode="${item.kode_barang}" data-kondisi="${item.kondisi}" data-nama="${item.nama_barang}">
                    ${item.nama_barang} (${item.merk || '-'}) — Tersedia: ${stokLabel}
                </option>`;
            });

            itemSelect.innerHTML = options;
            itemSelect.disabled = false;

            if (selItemId) {
                updateItemDetails();
            }
        }

        function updateItemDetails() {
            const opt = itemSelect.options[itemSelect.selectedIndex];
            if (opt && opt.value) {
                const stok = parseInt(opt.getAttribute('data-stok') || 1);
                const kode = opt.getAttribute('data-kode');
                const kondisi = opt.getAttribute('data-kondisi');
                const nama = opt.getAttribute('data-nama');

                jumlahInput.max = stok;
                hintStok.textContent = `Maks: ${stok} unit`;
                if (parseInt(jumlahInput.value) > stok) {
                    jumlahInput.value = stok;
                }

                infoNama.textContent = nama;
                infoKode.textContent = kode;
                infoKondisi.textContent = kondisi;
                infoStok.textContent = `${stok} Unit Siap Pakai`;
                infoBox.classList.remove('d-none');
            } else {
                infoBox.classList.add('d-none');
                hintStok.textContent = 'Maks: -';
            }
        }

        catSelect.addEventListener('change', function () {
            populateItems(this.value);
        });

        itemSelect.addEventListener('change', updateItemDetails);

        if (initialCatId) {
            populateItems(initialCatId, initialItemId);
        }
    }

    function updateRowNumbers() {
        const rows = itemsContainer.querySelectorAll('.item-row');
        rows.forEach((row, idx) => {
            row.querySelector('.row-label').innerHTML = `<i class="bi bi-box-seam me-1"></i> Barang #${idx + 1}`;
            const removeBtn = row.querySelector('.btn-remove-row');
            if (rows.length > 1) {
                removeBtn.classList.remove('d-none');
            } else {
                removeBtn.classList.add('d-none');
            }
        });
    }

    if (btnTambahAtas) btnTambahAtas.addEventListener('click', () => createItemRow());
    if (btnTambahBawah) btnTambahBawah.addEventListener('click', () => createItemRow());

    // Inisialisasi baris pertama atau restore data lama
    if (oldItemIds && oldItemIds.length > 0) {
        oldItemIds.forEach((itemId, i) => {
            let catId = '';
            for (const cat of categoriesData) {
                if (cat.items && cat.items.some(it => it.id == itemId)) {
                    catId = cat.id;
                    break;
                }
            }
            createItemRow(catId, itemId, oldJumlah[i] || 1);
        });
    } else {
        createItemRow(preselectedCatId, preselectedItemId, 1);
    }

    // Penanganan Tanggal & Waktu
    const tglPinjam = document.getElementById('tanggal_pinjam');
    const tglKembali = document.getElementById('tanggal_kembali');

    tglPinjam.addEventListener('change', function () {
        tglKembali.min = this.value;
        if (tglKembali.value < this.value) {
            tglKembali.value = this.value;
        }
    });

    const sampaiSelesaiCheck = document.getElementById('sampaiSelesaiCheck');
    const jamSelesaiInput = document.getElementById('jam_selesai');
    const jamSelesaiHint = document.getElementById('jamSelesaiHint');

    function handleSampaiSelesai() {
        if (sampaiSelesaiCheck.checked) {
            jamSelesaiInput.disabled = true;
            jamSelesaiInput.value = '';
            jamSelesaiHint.innerHTML = '<span class="text-success fw-semibold"><i class="bi bi-check-circle me-1"></i>Waktu berakhir akan tertulis: <strong>"selesai"</strong> di surat peminjaman.</span>';
        } else {
            jamSelesaiInput.disabled = false;
            if (!jamSelesaiInput.value) {
                jamSelesaiInput.value = '16:00';
            }
            jamSelesaiHint.innerHTML = 'Pilih jam atau centang <strong>"Sampai Selesai"</strong> jika waktu berakhir kondisional.';
        }
    }

    if (sampaiSelesaiCheck) {
        sampaiSelesaiCheck.addEventListener('change', handleSampaiSelesai);
        if (sampaiSelesaiCheck.checked) {
            handleSampaiSelesai();
        }
    }
});
</script>
@endpush
