@extends('layouts.app')
@section('page-title', 'Detail Buku')

@section('content')

{{-- BACK --}}
<div style="margin-bottom:20px;">
    <a href="{{ url()->previous() }}"
       style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:500; color:#64748b; text-decoration:none;">
        <i class="bi bi-arrow-left"></i> Kembali ke Katalog
    </a>
</div>

{{-- BOOK DETAIL CARD --}}
<div class="card">
    <div class="card-body" style="padding:28px;">
        <div class="row g-4">

            {{-- COVER --}}
            <div class="col-md-3 text-center">
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}"
                         style="width:100%; max-width:180px; height:auto; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); object-fit:cover;">
                @else
                    <div style="width:100%; max-width:180px; height:260px; background:linear-gradient(135deg,#e0e7ff,#ddd6fe); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                        <i class="bi bi-book" style="font-size:48px; color:#6366f1;"></i>
                    </div>
                @endif

                {{-- STATUS BADGE --}}
                <div style="margin-top:14px;">
                    @if($book->stok > 0)
                        <span class="badge" style="background:#ecfdf5; color:#065f46; font-size:13px; padding:6px 14px;">
                            <i class="bi bi-check-circle me-1"></i>Tersedia ({{ $book->stok }} stok)
                        </span>
                    @else
                        <span class="badge" style="background:#fef2f2; color:#991b1b; font-size:13px; padding:6px 14px;">
                            <i class="bi bi-x-circle me-1"></i>Stok Habis
                        </span>
                    @endif
                </div>
            </div>

            {{-- DETAIL --}}
            <div class="col-md-9">

                <h2 style="font-size:24px; font-weight:700; color:#0f172a; margin:0 0 8px;">
                    {{ $book->judul }}
                </h2>

                <div style="font-size:14px; color:#64748b; margin-bottom:6px;">
    <i class="bi bi-person-fill me-1"></i>
    Penulis: <strong style="color:#0f172a;">{{ $book->penulis }}</strong>
</div>

<div style="font-size:14px; color:#64748b; margin-bottom:6px;">
    <i class="bi bi-building me-1"></i>
    Penerbit: <strong style="color:#0f172a;">{{ $book->penerbit ?? '-' }}</strong>
</div>

<div style="font-size:14px; color:#64748b; margin-bottom:20px;">
    <i class="bi bi-tags me-1"></i>
    Genre: <strong style="color:#0f172a;">{{ $book->genre ?? '-' }}</strong>
</div>

                <hr style="border-color:#f1f5f9; margin:20px 0;">

                <h6 style="font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:#94a3b8; margin-bottom:10px;">
                    Deskripsi Buku
                </h6>
                <p style="font-size:14px; color:#475569; line-height:1.7; margin:0 0 24px;">
                    {{ $book->deskripsi ?? 'Deskripsi tidak tersedia.' }}
                </p>

                {{-- BORROW FORM --}}
                @if($book->stok > 0)

                    <div style="background:#f8fafc; border-radius:12px; padding:20px; border:1px solid #e2e8f0;">
                        <h6 style="font-size:14px; font-weight:700; color:#0f172a; margin:0 0 16px;">
                            <i class="bi bi-book-half me-2" style="color:#2563eb;"></i>
                            Ajukan Peminjaman
                        </h6>

                        <form action="/pinjam/{{ $book->id }}" method="POST">
                            @csrf
                            <div style="display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap;">
                                <div>
                                    <label style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:6px;">
                                        Durasi Peminjaman (hari)
                                    </label>
                                    <input type="number" name="durasi"
                                           class="form-control"
                                           placeholder="1 – 30 hari"
                                           min="1" max="30" required
                                           style="width:160px;">
                                </div>
                                <button type="submit" class="btn btn-primary" style="height:42px; padding:0 20px;">
                                    <i class="bi bi-send me-2"></i>Pinjam Buku
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- INFO PEMINJAMAN --}}
                    <div class="alert alert-warning mt-3 mb-0" style="font-size:13px;">
                        <h6 style="font-weight:700; margin-bottom:8px; font-size:13px;">
                            <i class="bi bi-info-circle-fill me-2"></i>Informasi Peminjaman
                        </h6>
                        <ul style="margin:0; padding-left:18px; line-height:1.8;">
                            <li>Maksimal peminjaman <strong>30 hari</strong></li>
                            <li>Buku harus dikembalikan sesuai tanggal yang ditentukan</li>
                            <li>Keterlambatan dikenakan denda <strong style="color:#dc2626;">Rp 1.000 / hari</strong></li>
                        </ul>
                    </div>

                @else

                    <button class="btn btn-secondary" disabled>
                        <i class="bi bi-x-circle me-2"></i>Stok Habis
                    </button>

                @endif

            </div>
        </div>
    </div>
</div>

@endsection