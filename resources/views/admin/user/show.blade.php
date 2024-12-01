@empty($user)

<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="bi bi-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/user/' . $user['user_id'] . '/detail') }}" method="POST" id="form-show">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="profile-header" style="text-align: center; padding: 20px;">
                <div class="profile-image-wrapper">
                    <img src="{{ asset($user_detail['user_detail_image']) }}" alt="Profile" class="profile-picture" style="width: 250px; height: 250px; border-radius: 50%;object-fit: cover;">
                    <input type="file" id="profile-upload" name="user_detail_image" style="display: none" accept="storage/image/*">
                </div>
            </div>
            <div class="modal-body">
                
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Jenis Pengguna:</th>
                        <td class="col-9">{{ $user['user_type']['user_type_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Username:</th>
                        <td class="col-9">{{ $user['username'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama Pengguna:</th>
                        <td class="col-9">{{ $user['user_fullname'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">NIP:</th>
                        <td class="col-9">{{ $user_detail['user_detail_nip'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">NIDN:</th>
                        <td class="col-9">{{ $user_detail['user_detail_nidn'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Email:</th>
                        <td class="col-9">{{ $user_detail['user_detail_email'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Telepon:</th>
                        <td class="col-9">{{ $user_detail['user_detail_phone'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Alamat:</th>
                        <td class="col-9">{{ $user_detail['user_detail_address'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</form>
@endempty

@push('js')
<script>
    $(document).ready(function() {
        // Toggle password visibility
        $('#togglePassword').on('click', function() {
            let passwordField = $('#password');
            let icon = $('#icon-eye');
            let isPasswordVisible = passwordField.attr('type') === 'password';

            passwordField.attr('type', isPasswordVisible ? 'text' : 'password');
            icon.toggleClass('fa-eye', !isPasswordVisible).toggleClass('fa-eye-slash', isPasswordVisible);
        });
    });
</script>
@endpush