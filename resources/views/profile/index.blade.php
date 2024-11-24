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
    <form method="POST" action="{{ url('/profile/update_image') }}" enctype="multipart/form-data" id="profileImageForm">
        @csrf
        @method('PUT')
        <div class="profile-image-wrapper">
            <img src="{{ asset($profile['user_detail_image']) }}" alt="Profile" class="profile-picture">
            <label for="profile-upload" class="edit-icon">
                <i class="bi bi-pencil-square"></i>
            </label>
            <input type="file" id="profile-upload" name="user_detail_image" style="display: none" accept="storage/image/*">
        </div>
        <h2>{{ $user['user_fullname'] }}</h2>
        <p class="role">{{ $user_type['user_type_name'] }}</p>
    </form>
</div>

    <div class="form-section">
        <div class="section-wrapper">
            <div class="section-header">
                <h2 class="section-title">Informasi Profil</h2>
                <p class="section-subtitle">Personal informasi profil dan alamat email akan diubah disini</p>
            </div>
            <div class="form-content">
                <form method="POST" action="{{ url('/profile/update') }}" id="profileForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{ $user['username'] }}">
                    </div>
                    <div class="form-group">
                        <label for="user_fullname">Nama</label>
                        <input type="text" id="user_fullname" name="user_fullname" class="form-control" value="{{ $user['user_fullname'] }}">
                    </div>
                    <div class="form-group">
                        <label for="user_detail_nip">NIP</label>
                        <input type="text" id="user_detail_nip" name="user_detail_nip" class="form-control" value="{{ $profile['user_detail_nip'] }}">
                    </div>
                    <div class="form-group">
                        <label for="user_detail_nidn">NIDN</label>
                        <input type="text" id="user_detail_nidn" name="user_detail_nidn" class="form-control" value="{{ $profile['user_detail_nidn'] }}" placeholder="Tidak perlu diisi jika tidak ada">
                    </div>
                    <div class="form-group">
                        <label for="user_detail_address">Alamat</label>
                        <input type="text" id="user_detail_address" ```blade
                        name="user_detail_address" class="form-control" value="{{ $profile['user_detail_address'] }}">
                    </div>
                    <div class="form-group">
                        <label for="user_detail_email">Email</label>
                        <input type="email" id="user_detail_email" name="user_detail_email" class="form-control" value="{{ $profile['user_detail_email'] }}">
                    </div>
                    <div class="form-group">
                        <label for="user_detail_phone">Telepon</label>
                        <input type="tel" id="user_detail_phone" name="user_detail_phone" class="form-control" value="{{ $profile['user_detail_phone'] }}">
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
                <p class="section-subtitle">Pastikan data yang dimasukkan valid, serta sesuai dengan yang diminta</p>
            </div>
            <div class="form-content">
                <form method="POST" action="{{ url('/profile/update_password') }}" id="passwordForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="old-password">Password Lama</label>
                        <input type="password" id="old-password" class="form-control" name="old_password" placeholder="Masukkan password lama">
                    </div>
                    <div class="form-group">
                        <label for="new-password">Password Baru</label>
                        <input type="password" id="new-password" class="form-control" name="new_password" placeholder="Masukkan password baru">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Password</label>
                        <input type="password" id="confirm-password" class="form-control" name="confirm_password" placeholder="Konfirmasi password baru">
                    </div>
                    <button type="submit" class="btn-submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        $("#profileForm").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                user_fullname: {
                    required: true,
                    minlength: 3
                },
                user_detail_nip: {
                    required: true,
                },
                user_detail_nidn: {
                    required: false, // Jika tidak wajib
                },
                user_detail_address: {
                    required: true
                },
                user_detail_email: {
                    required: true,
                },
                user_detail_phone: {
                    required: true,
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                location.reload(); // Muat ulang halaman
                            });
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    $(document).ready(function() {
        $("#passwordForm").validate({
            rules: {
                old_password: { minlength: 6 },
                new_password: { minlength: 6 },
                confirm_password: { minlength: 6, equalTo: "#new-password" }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response){
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            location.reload(); // Muat ulang halaman
                        });
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    $('#profile-upload').change(function() {
        var formData = new FormData($('#profileImageForm')[0]);
        
        $.ajax({
            url: '{{ url('/profile/update_image') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    // Memperbarui gambar profil di halaman
                    $('.profile-picture').attr('src', response.image_url);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Gambar profil berhasil diperbarui!'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal mengupload gambar!'
                });
            }
        });
    });
</script>
@endpush
@endsection