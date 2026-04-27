@extends('layouts.app')

@section('page-title', 'Profil Saya')

@section('content')

<style>
    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 32px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .profile-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    }
    .profile-avatar-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto 20px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    }
    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ffffff;
    }
    .profile-name {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .profile-email {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 16px;
    }
    .badge-role {
        padding: 6px 16px;
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        font-weight: 600;
        font-size: 13px;
        border-radius: 30px;
        text-transform: capitalize;
    }
    .form-group-custom {
        margin-bottom: 24px;
    }
    .form-label-custom {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
        display: block;
    }
    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        font-size: 15px;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .form-control-custom:focus {
        outline: none;
        border-color: #3b82f6;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .btn-gradient {
        background: linear-gradient(135deg, #2563eb, #6366f1);
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        color: white;
    }
    .btn-danger-custom {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 12px;
        border: 1px solid rgba(239, 68, 68, 0.2);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
    }
    .btn-danger-custom:hover {
        background: #ef4444;
        color: white;
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    .file-input-wrapper input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .file-input-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #f1f5f9;
        color: #475569;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 500;
        font-size: 14px;
        border: 1px dashed #cbd5e1;
        transition: all 0.2s;
    }
    .file-input-wrapper:hover .file-input-btn {
        background: #e2e8f0;
        border-color: #94a3b8;
    }
</style>



{{-- SUCCESS ALERT --}}
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: #ecfdf5; color: #065f46; font-weight: 500;">
        <i class="ph-fill ph-check-circle me-2"></i> Profil berhasil diperbarui!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">

    {{-- 🔹 INFO PROFILE (KIRI) --}}
    <div class="col-lg-4">
        <div class="profile-card text-center h-100">
            <div class="profile-avatar-wrapper">
                <img id="side-avatar"
                    src="{{ auth()->user()->photo 
                        ? asset('storage/' . auth()->user()->photo) 
                        : 'https://ui-avatars.com/api/?name=' . auth()->user()->name . '&background=random' }}"
                    class="profile-avatar">
            </div>

            <h5 class="profile-name">{{ auth()->user()->name }}</h5>
            <p class="profile-email">{{ auth()->user()->email }}</p>

            <div class="d-inline-block badge-role mt-2">
                <i class="ph-duotone ph-identification-badge me-1"></i> {{ auth()->user()->role }}
            </div>
            
            <div class="mt-4 pt-4" style="border-top: 1px dashed #e2e8f0;">
                <p style="font-size: 13px; color: #94a3b8; line-height: 1.6;">
                    Pastikan profil Anda selalu menggunakan data yang valid agar memudahkan identifikasi.
                </p>
            </div>
        </div>
    </div>

    {{-- 🔹 FORM EDIT (KANAN) --}}
    <div class="col-lg-8">
        <div class="profile-card h-100">

            <div class="section-title">
                <i class="ph-duotone ph-user-pen" style="color: #3b82f6; font-size: 24px;"></i> 
                Informasi Dasar
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Nama Lengkap</label>
                            <input type="text" name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="form-control-custom @error('name') border-danger @enderror" required>
                            @error('name')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Alamat Email</label>
                            <input type="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="form-control-custom @error('email') border-danger @enderror" required>
                            @error('email')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
    <div class="col-md-6">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" class="form-control-custom"
            value="{{ old('no_hp', auth()->user()->no_hp) }}"
            placeholder="Contoh: 08123456789">
    </div>

    <div class="col-md-6">
        <label class="form-label">Alamat</label>
        <input type="text" name="alamat" class="form-control-custom"
            value="{{ old('alamat', auth()->user()->alamat) }}"
            placeholder="Alamat lengkap">
    </div>
</div>

                <hr style="border-color: #f1f5f9; margin: 32px 0;">

                <div class="section-title">
                    <i class="ph-duotone ph-lock-key" style="color: #8b5cf6; font-size: 24px;"></i> 
                    Ubah Kata Sandi <span style="font-size: 13px; font-weight: normal; color: #94a3b8; margin-left: 8px;">(Opsional)</span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Kata Sandi Baru</label>
                            <input type="password" name="password" class="form-control-custom" placeholder="Kosongkan jika tidak diubah">
                            @error('password')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Konfirmasi Sandi Baru</label>
                            <input type="password" name="password_confirmation" class="form-control-custom" placeholder="Ulangi kata sandi baru">
                        </div>
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Foto Profil Baru</label>
                    <div class="d-flex align-items-center gap-3">
                        <img id="preview"
                            src="{{ auth()->user()->photo 
                                ? asset('storage/' . auth()->user()->photo) 
                                : 'https://ui-avatars.com/api/?name=' . auth()->user()->name . '&background=random' }}"
                            width="60"
                            height="60"
                            class="rounded-circle" style="object-fit:cover; border:2px solid #e2e8f0;">
                        
                        <div class="file-input-wrapper" style="width: 200px;">
                            <div class="file-input-btn">
                                <i class="ph-bold ph-upload-simple"></i> Unggah Foto
                            </div>
                            <input type="file" name="photo" accept="image/*" onchange="previewImage(event)">
                        </div>
                    </div>
                    @error('photo')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>


                <div class="mt-2 text-end">
                    <button type="submit" class="btn-gradient" style="width: auto; min-width: 200px;">
                        <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

            {{-- 🔴 HAPUS AKUN --}}
            <hr style="border-color: #f1f5f9; margin: 40px 0 32px;">

            <div class="section-title" style="color: #ef4444;">
                <i class="ph-duotone ph-warning-circle" style="font-size: 24px;"></i> 
                Zona Berbahaya
            </div>
            <p style="font-size: 14px; color: #64748b; margin-bottom: 20px;">
                Tindakan menghapus akun bersifat permanen. Semua data Anda akan dihapus dan tidak dapat dipulihkan.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="form-group-custom mb-md-0 mb-3">
                            <label class="form-label-custom text-danger">Masukkan kata sandi Anda untuk konfirmasi</label>
                            <input type="password" name="password" class="form-control-custom border-danger" required placeholder="Verifikasi identitas...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn-danger-custom" onclick="return confirm('Apakah Anda sangat yakin ingin menghapus akun ini secara permanen?')">
                            <i class="ph-bold ph-trash"></i> Hapus Akun
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>

{{-- SCRIPT PREVIEW --}}
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
        // Optionally update the side avatar too
        document.getElementById('side-avatar').src = reader.result;
    }
    if(event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>

@endsection