@extends('layouts.admin')

@section('title', 'Tambah Sarana Prasarana Baru - Admin SIPEMBAR MMC')
@section('page_title', 'Tambah Sarana Prasarana Baru')

@section('content')
<div class="pb-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Tambah Barang Inventaris Baru</h4>
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.items.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-semibold">Kategori Barang <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kode_barang" class="form-label fw-semibold">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode_barang" id="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" 
                                    value="{{ old('kode_barang') }}" placeholder="Contoh: MSK-005, SYT-006, PC-005" required>
                                @error('kode_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="nama_barang" class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" 
                                    value="{{ old('nama_barang') }}" placeholder="Contoh: Kamera Sony FX3 Cinema Line" required>
                                @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="merk" class="form-label fw-semibold">Merk / Brand</label>
                                <input type="text" name="merk" id="merk" class="form-control @error('merk') is-invalid @enderror" 
                                    value="{{ old('merk') }}" placeholder="Sony / Yamaha / Asus">
                                @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="stok_total" class="form-label fw-semibold">Stok Total Unit <span class="text-danger">*</span></label>
                                <input type="number" name="stok_total" id="stok_total" class="form-control @error('stok_total') is-invalid @enderror" 
                                    value="{{ old('stok_total', 1) }}" min="1" required>
                                @error('stok_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kondisi" class="form-label fw-semibold">Kondisi Barang <span class="text-danger">*</span></label>
                                <select name="kondisi" id="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik (Siap Pakai)</option>
                                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="lokasi_penyimpanan" class="form-label fw-semibold">Lokasi Penyimpanan di Lab</label>
                                <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" class="form-control" 
                                    value="{{ old('lokasi_penyimpanan') }}" placeholder="Contoh: Lemari A Lab Multimedia Lt. 2">
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi & Kelengkapan</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" 
                                    placeholder="Kelengkapan: charger, kabel HDMI, tas...">{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

