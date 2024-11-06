<form action="{{ url('/user/import_ajax') }}" method="POST" id="form-import">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('template_user.xlsx') }}" class="btn btn-info btn-sm" download><i
                            class="fa fa-file-excel"></i>Download</a>
                    <small id="error-level_id" class="error-text form-text text-danger"></small>
                </div>
                <p>Anda dapat mengimpor data pengguna dengan mengklik tombol di bawah ini.</p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="button" id="btn-import-static" class="btn btn-primary">Import Data Statis</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#btn-import-static").on('click', function() {
            $.ajax({
                url: "{{ url('/user/import_ajax') }}", // Sesuaikan dengan URL endpoint
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}' // Kirimkan CSRF token
                },
                success: function(response) {
                    if (response.status) { // jika sukses
                        $('#modal-master').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        tableUser .ajax.reload(); // reload datatable
                    } else { // jika error
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal mengimpor data.'
                    });
                }
            });
        });
    });
</script>