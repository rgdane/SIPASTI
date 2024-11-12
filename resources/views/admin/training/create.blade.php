<form action="{{ url('/training/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Vendor Pelatihan -->
                <div class="form-group">
                    <label for="training_vendor_id">Vendor Pelatihan</label>
                    <select name="training_vendor_id" id="training_vendor_id" class="form-control" required>
                        <option value="">- Pilih Vendor -</option>
                        <option value="1">Google</option>
                        <option value="2">Microsoft</option>
                        <option value="3">IBM</option>
                    </select>
                    <small id="error-training_vendor_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tipe Seritifikasi -->
                <div class="form-group">
                    <label for="training_type_id">Tipe Pelatihan</label>
                    <select name="training_type_id" id="training_type_id" class="form-control" required>
                        <option value="">- Pilih Tipe Pelatihan -</option>
                        <option value="1">Mandiri</option>
                        <option value="2">Non-Mandiri</option>
                    </select>
                    <small id="error-training_type_id" class="error-text form-text text-danger"></small>
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

                <!-- Nama Pelatihan -->
                <div class="form-group">
                    <label for="training_name">Nama Pelatihan</label>
                    <input value="" type="text" name="training_name" id="training_name" class="form-control" required>
                    <small id="error-training_name" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Pelatihan -->
                <div class="form-group">
                    <label for="training_date">Tanggal Pelatihan</label>
                    <input value="" type="datetime-local" name="training_date" id="training_date" class="form-control" required>
                    <small id="error-training_date" class="error-text form-text text-danger"></small>
                </div>

                <!-- Lokasi Pelatihan -->
                <div class="form-group">
                    <label for="training_location">Lokasi Pelatihan</label>
                    <input value="" type="text" name="training_location" id="training_location" class="form-control" required>
                    <small id="error-training_location" class="error-text form-text text-danger"></small>
                </div>

                <!-- Biaya Pelatihan -->
                <div class="form-group">
                    <label for="training_cost">Biaya Pelatihan</label>
                    <input value="" type="number" name="training_cost" id="training_cost" class="form-control" required>
                    <small id="error-training_cost" class="error-text form-text text-danger"></small>
                </div>

                <!-- Kuota Pelatihan -->
                <div class="form-group">
                    <label for="training_quota">Kuota Pelatihan</label>
                    <input value="" type="number" name="training_quota" id="training_quota" class="form-control" required>
                    <small id="error-training_quota" class="error-text form-text text-danger"></small>
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
                training_type_id: {
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
                training_name: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                training_date: {
                    required: true
                },
                training_location: {
                    required: true,
                    minlength: 10,
                    maxlength: 255 // corrected spelling
                },
                training_cost: {
                    required: true,
                    number: true
                },
                training_quota: {
                    required: true,
                    number: true
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
                            dataTraining.ajax.reload();
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
