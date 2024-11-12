<form action="{{ url('/trainingVendor/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Vendor Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Nama Vendor -->
                <div class="form-group">
                    <label for="training_vendor_name">Nama Vendor Pelatihan</label>
                    <input value="" type="text" name="training_vendor_name" id="training_vendor_name"
                        class="form-control" required>
                    <small id="error-training_vendor_name" class="error-text form-text text-danger"></small>
                </div>

                <!-- Alamat Vendor -->
                <div class="form-group">
                    <label for="training_vendor_address">Alamat Vendor</label>
                    <input value="" type="text" name="training_vendor_address" id="training_vendor_address"
                        class="form-control" required>
                    <small id="error-training_vendor_address" class="error-text form-text text-danger"></small>
                </div>

                <!-- Kota Vendor -->
                <div class="form-group">
                    <label for="training_vendor_city">Kota Vendor Pelatihan</label>
                    <input value="" type="text" name="training_vendor_city" id="training_vendor_city"
                        class="form-control" required>
                    <small id="error-training_vendor_city" class="error-text form-text text-danger"></small>
                </div>

                <!-- Nomor HP Vendor -->
                <div class="form-group">
                    <label for="training_vendor_phone">PIC Vendor</label>
                    <input value="" type="text" name="training_vendor_phone" id="training_vendor_phone"
                        class="form-control" required>
                    <small id="error-training_vendor_phone" class="error-text form-text text-danger"></small>
                </div>

                <!-- Website Vendor -->
                <div class="form-group">
                    <label for="training_vendor_web">Website</label>
                    <input value="" type="url" name="training_vendor_web" id="training_vendor_web"
                        class="form-control" required>
                    <small id="error-training_vendor_web" class="error-text form-text text-danger"></small>
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
        $("#form-tambah").validate({
            rules: {
                training_vendor_id: {
                    required: true,
                    number: true
                },
                training_vendor_name: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                training_vendor_address: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                training_vendor_city: {
                    required: true,
                    minlength: 5,
                    maxlength: 50
                },
                training_vendor_phone: {
                    required: true,
                    minlength: 12,
                    maxlength: 20
                },
                training_vendor_web: {
                    required: true,
                    url: true
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
                            });
                            dataTrainingVendor.ajax.reload();
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