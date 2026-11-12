@extends('layouts.app')

@section('title', 'Edit Barang ' . $item->kode_barang)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Edit Data Barang (<code>{{ $item->kode_barang }}</code>)</h4>
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-semibold">Kategori Barang <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ old('category_id', $item->category_id) == $c->id ? 'selected' : '' }}>
                                            {{ $c->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kode_barang" class="form-label fw-semibold">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode_barang" id="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" 
                                    value="{{ old('kode_barang', $item->kode_barang) }}" required>
                                @error('kode_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="nama_barang" class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" 
                                    value="{{ old('nama_barang', $item->nama_barang) }}" required>
                                @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="merk" class="form-label fw-semibold">Merk / Brand</label>
                                <input type="text" name="merk" id="merk" class="form-control @error('merk') is-invalid @enderror" 
                                    value="{{ old('merk', $item->merk) }}">
                                @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="stok_total" class="form-label fw-semibold">Stok Total Unit <span class="text-danger">*</span></label>
                                <input type="number" name="stok_total" id="stok_total" class="form-control @error('stok_total') is-invalid @enderror" 
                                    value="{{ old('stok_total', $item->stok_total) }}" min="0" required>
                                @error('stok_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="stok_tersedia" class="form-label fw-semibold">Stok Tersedia <span class="text-danger">*</span></label>
                                <input type="number" name="stok_tersedia" id="stok_tersedia" class="form-control @error('stok_tersedia') is-invalid @enderror" 
                                    value="{{ old('stok_tersedia', $item->stok_tersedia) }}" min="0" required>
                                @error('stok_tersedia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="kondisi" class="form-label fw-semibold">Kondisi Barang <span class="text-danger">*</span></label>
                                <select name="kondisi" id="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    <option value="Baik" {{ old('kondisi', $item->kondisi) == 'Baik' ? 'selected' : '' }}>Baik (Siap Pakai)</option>
                                    <option value="Rusak Ringan" {{ old('kondisi', $item->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi', $item->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="lokasi_penyimpanan" class="form-label fw-semibold">Lokasi Penyimpanan di Lab</label>
                                <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" class="form-control" 
                                    value="{{ old('lokasi_penyimpanan', $item->lokasi_penyimpanan) }}">
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi & Kelengkapan</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Perbarui Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

