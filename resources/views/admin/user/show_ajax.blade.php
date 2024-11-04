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
<form action="{{ url('/user/' . $user['user_id'] . '/detail_ajax') }}" method="POST" id="form-show">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Level Pengguna:</th>
                        <td class="col-9">{{ $user['level']['level_nama'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Username:</th>
                        <td class="col-9">{{ $user['username'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama:</th>
                        <td class="col-9">{{ $user['nama'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Password:</th>
                        <td class="col-9">
                            <div class="input-group">
                                <input type="password" class="form-control" id="password"
                                    value="{{ $user['password'] ?? '********' }}" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i id="icon-eye" class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
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