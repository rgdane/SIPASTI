@empty($certificationVendor)
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
            <a href="{{ url('/certificationVendor') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/certificationVendor/' . $certificationVendor['certification_vendor_id'] . '/delete_ajax') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Vendor Sertifikasi</h5>
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
                        <th class="text-right col-3">Nama Vendor Sertifikasi:</th>
                        <td class="col-9">{{ $certificationVendor['certification_vendor_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Alamat:</th>
                        <td class="col-9">{{ $certificationVendor['certification_vendor_address'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kota:</th>
                        <td class="col-9">{{ $certificationVendor['certification_vendor_city'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">PIC Vendor:</th>
                        <td class="col-9">{{ $certificationVendor['certification_vendor_phone'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Website:</th>
                        <td class="col-9">{{ $certificationVendor['certification_vendor_web'] }}</td>
                    </tr>
                </table>
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
                                dataCertificationVendor.ajax.reload();
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
