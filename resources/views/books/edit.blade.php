@extends('layouts.app')
@section('page-title', 'Edit Buku')

@section('content')

{{-- BACK + HEADER --}}
<div class="page-header">
    <div>
        <a href="{{ route('books.index') }}"
           style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:500; color:#64748b; text-decoration:none; margin-bottom:8px;">
            <i class="bi bi-arrow-left"></i> Kembali ke Kelola Buku
        </a>
        <h1 class="page-title">Edit Buku</h1>
        <p class="page-subtitle">Perbarui informasi buku: <strong>{{ $book->judul }}</strong></p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
        <div class="card">
            <div class="card-body" style="padding: 28px;">

                <form method="POST" action="/books/{{ $book->id }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ROW 1: Judul & Penulis --}}
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-type me-1" style="color:#2563eb;"></i>
                                Judul Buku <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="text" name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul', $book->judul) }}"
                                   required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-person me-1" style="color:#2563eb;"></i>
                                Nama Penulis <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="text" name="penulis"
                                   class="form-control @error('penulis') is-invalid @enderror"
                                   value="{{ old('penulis', $book->penulis) }}"
                                   required>
                            @error('penulis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ROW 2: Stok & Edit Cover --}}
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-stack me-1" style="color:#2563eb;"></i>
                                Jumlah Stok <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="number" name="stok"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', $book->stok) }}"
                                   min="0"
                                   required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="bi bi-arrow-repeat me-1" style="color:#2563eb;"></i>
                                {{ $book->cover ? 'Ganti Cover' : 'Upload Cover' }}
                            </label>
                            <input type="file" name="cover" id="coverInput"
                                   class="form-control"
                                   accept="image/*">
                            <small style="color:#94a3b8; font-size:12px; margin-top:4px; display:block;">
                                Kosongkan jika tidak ingin mengganti cover.
                            </small>
                        </div>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-text-paragraph me-1" style="color:#2563eb;"></i>
                            Deskripsi / Sinopsis
                        </label>
                        <textarea name="deskripsi" class="form-control" rows="4"
                                  placeholder="Tuliskan sinopsis singkat buku ini...">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                    </div>

                    <div class="row">
                        {{-- COVER SAAT INI --}}
                        @if($book->cover)
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="bi bi-image me-1" style="color:#2563eb;"></i>
                                    Cover Saat Ini
                                </label>
                                <div>
                                    <img src="{{ asset('storage/' . $book->cover) }}"
                                         style="max-width:140px; max-height:200px; object-fit:cover; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                                </div>
                            </div>
                        @endif

                        {{-- PREVIEW BARU --}}
                        <div id="previewContainer" class="col-md-6 mb-4" style="display:none;">
                            <label class="form-label">Pratinjau Cover Baru</label>
                            <div>
                                <img id="preview"
                                     style="max-width:140px; max-height:200px; object-fit:cover; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-2"></i>Simpan Perubahan
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