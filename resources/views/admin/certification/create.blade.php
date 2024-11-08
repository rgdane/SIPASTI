<form action="{{ url('/certification/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Vendor Sertifikasi -->
                <div class="form-group">
                    <label for="certification_vendor_id">Vendor Sertifikasi</label>
                    <select name="certification_vendor_id" id="certification_vendor_id" class="form-control" required>
                        <option value="">- Pilih Vendor -</option>
                        <option value="1">Google</option>
                        <option value="2">BNSP</option>
                        <option value="3">IBM</option>
                    </select>
                    <small id="error-certification_vendor_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tipe Seritifikasi -->
                <div class="form-group">
                    <label for="certification_type_id">Tipe Sertifikasi</label>
                    <select name="certification_type_id" id="certification_type_id" class="form-control" required>
                        <option value="">- Pilih Tipe Sertifikasi -</option>
                        <option value="1">Sertifikasi Profesi</option>
                        <option value="2">Sertifikasi</option>
                    </select>
                    <small id="error-certification_type_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Level Seritifikasi -->
                <div class="form-group">
                    <label for="certification_level_id">Level Sertifikasi</label>
                    <select name="certification_level_id" id="certification_level_id" class="form-control" required>
                        <option value="">- Pilih Level Sertifikasi -</option>
                        <option value="1">Internasional</option>
                        <option value="2">Nasional</option>
                        <option value="3">Regional</option>
                    </select>
                    <small id="error-certification_level_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Mata Kuliah -->
                <div class="form-group">
                    <label for="course_id">Mata Kuliah</label>
                    <select name="course_id" id="course_id" class="form-control" required>
                        <option value="">- Pilih Mata Kuliah -</option>
                        <option value="1">Pemrograman Web</option>
                        <option value="2">Data Mining</option>
                        <option value="3">Data Warehouse</option>
                        <option value="4">Business Intellegent</option>
                        <option value="5">Workshop</option>
                    </select>
                    <small id="error-course_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Bidang Minat -->
                <div class="form-group">
                    <label for="interest_id">Bidang Minat</label>
                    <select name="interest_id" id="interest_id" class="form-control" required>
                        <option value="">- Pilih Bidang Minat -</option>
                        <option value="1">Big Data</option>
                        <option value="2">Business</option>
                        <option value="3">Development</option>
                    </select>
                    <small id="error-interest_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Nama Sertifikasi -->
                <div class="form-group">
                    <label for="certification_name">Nama Sertifikasi</label>
                    <input value="" type="text" name="certification_name" id="certification_name" class="form-control"
                        required>
                    <small id="error-certification_name" class="error-text form-text text-danger"></small>
                </div>

                <!-- Nomor Sertifikasi -->
                <div class="form-group">
                    <label for="certification_number">Nomor Sertifikasi</label>
                    <input value="" type="text" name="certification_number" id="certification_number"
                        class="form-control" required>
                    <small id="error-certification_number" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Sertifikasi -->
                <div class="form-group">
                    <label for="certification_date">Tanggal Sertifikasi</label>
                    <input value="" type="datetime-local" name="certification_date" id="certification_date"
                        class="form-control" required>
                    <small id="error-certification_date" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tenggat Sertifikasi -->
                <div class="form-group">
                    <label for="certification_expired">Tenggat Sertifikasi</label>
                    <input value="" type="datetime-local" name="certification_expired" id="certification_expired"
                        class="form-control" required>
                    <small id="error-certification_expired" class="error-text form-text text-danger"></small>
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
                certification_vendor_id: {
                    required: true,
                    number: true
                },
                certification_type_id: {
                    required: true,
                    number: true
                },
                course_id: {
                    required: true,
                    number: true
                },
                interest_id: {
                    required: true,
                    number: true
                },
                certification_name: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                certification_number: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                certification_date: {
                    required: true,
                },
                certification_expired: {
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
                            });
                            dataCertification.ajax.reload();
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