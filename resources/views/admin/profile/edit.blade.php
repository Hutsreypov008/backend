@extends('admin.layout')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<style>
    .profile-header-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .profile-cover {
        height: 140px;
        background: linear-gradient(135deg, var(--primary), #5A52D5, #7C73FF);
        position: relative;
        overflow: hidden;
    }

    .profile-cover::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 20% 50%, rgba(255,255,255,0.08) 1px, transparent 1px),
            radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 60px 60px;
    }

    .profile-body {
        padding: 0 2rem 2rem;
        margin-top: -50px;
        position: relative;
    }

    .profile-avatar-section {
        display: flex;
        align-items: flex-end;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .avatar-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }

    .avatar-inner {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 700;
        color: white;
        overflow: hidden;
    }

    .avatar-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0.5);
        color: white;
        border-radius: 50%;
        opacity: 0;
        cursor: pointer;
        transition: opacity 0.25s ease;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
        line-height: 1.2;
    }

    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    .profile-details {
        padding-bottom: 0.5rem;
    }

    .profile-details h2 {
        margin: 0 0 0.25rem;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .profile-details .profile-email {
        color: var(--text-muted);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .profile-details .profile-email i {
        font-size: 0.85rem;
    }

    /* ==================== FORM CARD ==================== */
    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .form-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .form-card .card-head i {
        color: var(--primary);
    }

    .form-card .card-body {
        padding: 1.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.4rem;
    }

    .form-group label i {
        color: var(--primary);
        margin-right: 0.3rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        font-size: 0.9rem;
        color: var(--text-dark);
        background: #FAFBFc;
        transition: all 0.25s ease;
        outline: none;
    }

    .form-control:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.08);
    }

    .form-control::placeholder {
        color: #B0B0B8;
    }

    .file-upload-wrap {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: #F8F9FE;
        border: 1.5px dashed #D1D5DB;
        border-radius: 12px;
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .file-upload-wrap:hover {
        border-color: var(--primary);
        background: #F0EFFF;
    }

    .file-upload-wrap i {
        font-size: 1.5rem;
        color: var(--primary);
    }

    .file-upload-wrap .upload-text {
        flex: 1;
    }

    .file-upload-wrap .upload-text strong {
        display: block;
        font-size: 0.85rem;
        color: var(--text-dark);
    }

    .file-upload-wrap .upload-text span {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .file-upload-wrap input[type="file"] {
        display: none;
    }

    .image-preview {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: 12px;
        margin-top: 0.75rem;
        animation: fadeSlideIn 0.3s ease;
    }

    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .image-preview img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .image-preview .preview-info {
        flex: 1;
        font-size: 0.82rem;
    }

    .image-preview .preview-info strong {
        display: block;
        color: #166534;
    }

    .image-preview .preview-info span {
        color: #4ADE80;
        font-size: 0.72rem;
    }

    .image-preview .remove-btn {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: none;
        background: rgba(239,68,68,0.1);
        color: #EF4444;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .image-preview .remove-btn:hover {
        background: #EF4444;
        color: white;
    }

    .submit-row {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid #F0F0F5;
    }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.75rem;
        background: linear-gradient(135deg, var(--primary), #5A52D5);
        color: white;
        border: none;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(108, 99, 255, 0.3);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 99, 255, 0.4);
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.5rem;
        background: white;
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        color: var(--text-muted);
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-secondary:hover {
        border-color: #D1D5DB;
        color: var(--text-dark);
        background: #F9FAFB;
    }

    .alert-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        animation: fadeSlideIn 0.3s ease;
    }

    .alert-success i {
        font-size: 1.2rem;
    }
</style>

{{-- ==================== PROFILE HEADER ==================== --}}
<div class="profile-header-card">
    <div class="profile-cover"></div>
    <div class="profile-body">
        <div class="profile-avatar-section">
            <div class="avatar-wrapper">
                <div class="avatar-circle">
                    @php
                        $initials = strtoupper(substr($user->name, 0, 1));
                        $hasImage = !empty($user->profile_image);
                    @endphp
                    <div class="avatar-inner" style="background: {{ $hasImage ? 'transparent' : 'var(--primary)' }};">
                        @if($hasImage)
                            <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" />
                        @else
                            {{ $initials }}
                        @endif
                    </div>
                </div>
                <label class="avatar-overlay" for="profile_image_input" title="Change photo">
                    Change<br>Photo
                </label>
            </div>
            <div class="profile-details">
                <h2>{{ $user->name }}</h2>
                <div class="profile-email">
                    <i class="bi bi-envelope-fill"></i>
                    {{ $user->email }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== SUCCESS MESSAGE ==================== --}}
@if(session('success'))
    <div class="alert-success">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

{{-- ==================== EDIT FORM ==================== --}}
<div class="form-card">
    <div class="card-head">
        <i class="bi bi-pencil-square"></i>
        <h5>Edit Profile</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="name"><i class="bi bi-person-fill"></i>Full Name</label>
                    <input id="name" type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name) }}" required placeholder="Enter your name">
                    @error('name')
                        <small style="color: #EF4444; font-size: 0.78rem; margin-top: 0.25rem; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email"><i class="bi bi-envelope-fill"></i>Email Address</label>
                    <input id="email" type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required placeholder="Enter your email">
                    @error('email')
                        <small style="color: #EF4444; font-size: 0.78rem; margin-top: 0.25rem; display: block;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- File Upload --}}
            <div class="form-group" style="margin-bottom: 0;">
                <label><i class="bi bi-image"></i>Profile Photo</label>

                <label class="file-upload-wrap" id="fileUploadWrap">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <div class="upload-text">
                        <strong>Click to upload a new photo</strong>
                        <span>JPG, PNG or WebP — Max 2MB</span>
                    </div>
                    <input type="file" id="profile_image_input" name="profile_image"
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           onchange="previewImage(this)">
                </label>

                @error('profile_image')
                    <small style="color: #EF4444; font-size: 0.78rem; margin-top: 0.25rem; display: block;">{{ $message }}</small>
                @enderror

                {{-- Preview --}}
                <div id="imagePreview" class="image-preview" style="display: none;">
                    <img id="previewImg" src="" alt="Preview" />
                    <div class="preview-info">
                        <strong>New photo selected</strong>
                        <span id="previewFileName"></span>
                    </div>
                    <button type="button" class="remove-btn" onclick="clearImageInput()" title="Remove">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

            <div class="submit-row">
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
                <button type="submit" class="btn-save">
                    <i class="bi bi-check-lg"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const img = document.getElementById('previewImg');
        const fileName = document.getElementById('previewFileName');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
            }

            reader.readAsDataURL(file);
            fileName.textContent = file.name;
            preview.style.display = 'flex';
        }
    }

    function clearImageInput() {
        const input = document.getElementById('profile_image_input');
        const preview = document.getElementById('imagePreview');
        input.value = '';
        preview.style.display = 'none';
    }
</script>
@endsection
