@empty($certification_vendor)
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
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan.
            </div>
            <a href="{{ url('/certification_vendor') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/certification_vendor/' . $certification_vendor['certification_vendor_id'] . '/update') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Vendor Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="certification_vendor_name">Nama Vendor Sertifikasi</label>
                    <input value="{{ old('certification_vendor_name', $certification_vendor['certification_vendor_name']) }}" type="text" name="certification_vendor_name" id="certification_vendor_name"
                        class="form-control" required>
                    <small id="error-certification_vendor_name" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="certification_vendor_address">Alamat</label>
                    <input value="{{ old('certification_vendor_address', $certification_vendor['certification_vendor_address']) }}" type="text" name="certification_vendor_address" id="certification_vendor_address"
                        class="form-control" required>
                    <small id="error-certification_vendor_address" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="certification_vendor_city">Kota</label>
                    <input value="{{ old('certification_vendor_city', $certification_vendor['certification_vendor_city']) }}" type="text" name="certification_vendor_city" id="certification_vendor_city"
                        class="form-control" required>
                    <small id="error-certification_vendor_city" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="certification_vendor_phone">PIC Vendor</label>
                    <input value="{{ old('certification_vendor_phone', $certification_vendor['certification_vendor_phone']) }}" type="text" name="certification_vendor_phone" id="certification_vendor_phone"
                        class="form-control" required>
                    <small id="error-certification_vendor_phone" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="certification_vendor_web">Webiste</label>
                    <input value="{{ old('certification_vendor_web', $certification_vendor['certification_vendor_web']) }}" type="url" name="certification_vendor_web" id="certification_vendor_web"
                        class="form-control" required>
                    <small id="error-certification_vendor_web" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    level_id: { required: true, number: true },
                    username: { required: true, minlength: 3, maxlength: 20 },
                    nama: { required: true, minlength: 3, maxlength: 100 },
                    password: { minlength: 6, maxlength: 20 }
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
                                });
                                dataCertificationVendor.ajax.reload();
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
</script>
@endempty