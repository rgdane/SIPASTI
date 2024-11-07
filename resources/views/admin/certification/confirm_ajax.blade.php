@empty($certification)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="bi bi-x-circle-fill"></i> Kesalahan!!!</h5> <!-- Updated icon -->
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/certification') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/certification/' . $certification['certification_id'] . '/delete_ajax') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi !!!</h5> <!-- Updated icon -->
                    Apakah Anda ingin menghapus data seperti dibawah ini?
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Nama Sertifikasi:</th>
                        <td class="col-9">{{ $certification['certification_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nomor Sertifikasi:</th>
                        <td class="col-9">{{ $certification['certification_number'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Sertifikasi:</th>
                        <td class="col-9">{{ $certification['certification_date'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tenggat Sertifikasi:</th>
                        <td class="col-9">{{ $certification['certification_expired'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Vendor Sertifikasi:</th>
                        <td class="col-9">{{ $certification['vendor']['certification_vendor_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tipe Sertifikasi:</th>
                        <td class="col-9">{{ $certification['type']['certification_type_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Level Sertifikasi:</th>
                        <td class="col-9">{{ $certification['level']['certification_level_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Mata Kuliah:</th>
                        <td class="col-9">{{ $certification['course']['course_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Bidang Minat:</th>
                        <td class="col-9">{{ $certification['interest']['interest_name'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Ya, Hapus</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
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
                                });
                                dataCertification.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-'+prefix).text(val[0]);
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
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    elemtnt.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</script>
@endempty
