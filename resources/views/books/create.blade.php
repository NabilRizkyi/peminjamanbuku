@extends('layouts.app')
@section('page-title', 'Tambah Buku')

@section('content')

<div class="page-header">
    <div>
        <a href="{{ route('books.index') }}"
           style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:500; color:#64748b; text-decoration:none; margin-bottom:8px;">
            <i class="bi bi-arrow-left"></i> Kembali ke Kelola Buku
        </a>
        <h1 class="page-title">Tambah Buku Baru</h1>
        <p class="page-subtitle">Isi informasi buku yang akan ditambahkan ke koleksi</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
        <div class="card">
            <div class="card-body" style="padding: 28px;">

                <form method="POST" action="/books" enctype="multipart/form-data">
                    @csrf

                    {{-- ROW 1 --}}
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-type me-1 text-primary"></i>
                                Judul Buku
                            </label>
                            <input type="text" name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   placeholder="Contoh: Laskar Pelangi"
                                   value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-person me-1 text-primary"></i>
                                Nama Penulis
                            </label>
                            <input type="text" name="penulis"
                                   class="form-control @error('penulis') is-invalid @enderror"
                                   placeholder="Contoh: Andrea Hirata"
                                   value="{{ old('penulis') }}" required>
                            @error('penulis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ROW 2 --}}
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-stack me-1 text-primary"></i>
                                Jumlah Stok
                            </label>
                            <input type="number" name="stok"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   placeholder="Contoh: 5"
                                   value="{{ old('stok') }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-image me-1 text-primary"></i>
                                Cover Buku
                            </label>
                            <input type="file" name="cover" id="coverInput"
                                   class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                        </div>
                    </div>

                    {{-- ROW 3 (FIX PENERBIT) --}}
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-building me-1 text-primary"></i>
                                Penerbit 
                            </label>
                            <input type="text" name="penerbit"
                                   class="form-control @error('penerbit') is-invalid @enderror"
                                   placeholder="Contoh: Bentang Pustaka"
                                   value="{{ old('penerbit') }}" required>
                            @error('penerbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-building me-1 text-primary"></i>
                                Genre
                            </label>
                            <input type="text" name="genre"
                                   class="form-control @error('genre') is-invalid @enderror"
                                   placeholder="Contoh: Fiksi"
                                   value="{{ old('fiksi') }}" required>
                            @error('genre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-text-paragraph me-1 text-primary"></i>
                            Deskripsi / Sinopsis
                        </label>
                        <textarea name="deskripsi"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Tuliskan sinopsis singkat buku ini...">{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- PREVIEW --}}
                    <div id="previewContainer" class="mb-4" style="display:none;">
                        <label class="form-label">Pratinjau Cover</label><br>
                        <img id="preview"
                             style="max-width:140px; border-radius:10px;">
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-2"></i>Simpan Buku
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary px-4">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
const coverInput = document.getElementById('coverInput');
const preview = document.getElementById('preview');
const previewContainer = document.getElementById('previewContainer');

coverInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        previewContainer.style.display = 'block';
    } else {
        previewContainer.style.display = 'none';
    }
});
</script>

@endsection