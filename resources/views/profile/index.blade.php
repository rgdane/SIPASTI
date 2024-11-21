@extends('layouts.template')

@section('content')
<style>
    .container {
        display: inline;
    }

    .profile-header {
        text-align: center;
        padding: 20px;
        position: relative;
    }

    .profile-image-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }

    .profile-picture {
        width: 350px;
        height: 350px;
        border-radius: 50%;
        object-fit: cover;
    }

    .edit-icon {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: #fff;
        border-radius: 50%;
        padding: 8px;
    }

    .edit-icon i {
        font-size: 28px;
        color: #000000;
    }

    .profile-header h2 {
        margin: 10px 0 5px;
        font-size: 24px;
        font-weight: bold;
    }

    .role {
        font-size: 16px;
        color: #666;
    }

    .form-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .section-wrapper {
        display: flex;
        gap: 40px;
    }

    .section-header {
        flex: 0 0 200px;
    }

    .section-title {
        font-size: 16px;
        color: #333;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .section-subtitle {
        font-size: 12px;
        color: #666;
    }

    .form-content {
        flex: 1;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-submit {
        background-color: #0056b3;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        width: 200px;
    }

    .btn-submit:hover {
        background-color: #004494;
    }

    @media (max-width: 768px) {
        .section-wrapper {
            flex-direction: column;
            gap: 20px;
        }

        .section-header {
            flex: none;
        }

        .btn-submit {
            width: 100%;
        }
    }
</style>
<div class="container">
    <div class="profile-header">
        <div class="profile-image-wrapper">
            <img src="{{ asset('image/agta.jpg') }}" alt="Profile" class="profile-picture">
            <label for="profile-upload" class="edit-icon">
                <i class="bi bi-pencil-square"></i>
            </label>
            <input type="file" id="profile-upload" style="display: none" accept="image/*">
        </div>
        <h2>{{ $user['name'] }}</h2>
        <p class="role">{{ $user['role'] }}</p>
    </div>

    <div class="form-section">
        <div class="section-wrapper">
            <div class="section-header">
                <h2 class="section-title">Informasi Profil</h2>
                <p class="section-subtitle">Personal informasi profil dan alamat email akan diubah disini</p>
            </div>
            <div class="form-content">
                <form id="profileForm">
                    <div class="form-group">
                        <label for="nidn">NIDN</label>
                        <input type="text" id="nidn" name="nidn" class="form-control" value="{{ $user['nidn'] }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $user['name'] }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" id="address" name="address" class="form-control"
                            value="{{ $user['address'] }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $user['email'] }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="{{ $user['phone'] }}">
                    </div>
                    <button type="submit" class="btn-submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="section-wrapper">
            <div class="section-header">
                <h2 class="section-title">Updated Password</h2>
                <p class="section-subtitle">Pastikan data yang dimasukkan valid, serta sesuai dengan yang diminta
                </p>
            </div>
            <div class="form-content">
                <form id="passwordForm">
                    <div class="form-group">
                        <label for="old-password">Password Lama</label>
                        <input type="password" id="old-password" class="form-control" name="old_password"
                            placeholder="Masukkan password lama">
                    </div>
                    <div class="form-group">
                        <label for="new-password">Password Baru</label>
                        <input type="password" id="new-password" class="form-control" name="new_password"
                            placeholder="Masukkan password baru">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Password</label>
                        <input type="password" id="confirm-password" class="form-control" name="confirm_password"
                            placeholder="Konfirmasi password baru">
                    </div>
                    <button type="submit" class="btn-submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your profile update logic here
        alert('Profile updated successfully!');
    });

    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your password update logic here
        alert('Password updated successfully!');
    });
</script>
<script>
    document.getElementById('profile-upload').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            // Di sini Anda bisa menambahkan logika untuk mengunggah gambar
            // Misalnya menggunakan AJAX untuk mengirim file ke server
            const file = e.target.files[0];
            const formData = new FormData();
            formData.append('profile_image', file);
            
            // Contoh penggunaan fetch untuk upload
            /*
            fetch('/update-profile-image', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                // Handle response
                if(data.success) {
                    // Update gambar profil
                    document.querySelector('.profile-picture').src = data.image_url;
                }
            })
            .catch(error => console.error('Error:', error));
            */
        }
    });
</script>
@endpush
@endsection