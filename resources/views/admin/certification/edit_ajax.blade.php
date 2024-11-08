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
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan.
            </div>
            <a href="{{ url('/certification') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/certification/' . $certification['certification_id'] . '/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Vendor Sertifikasi --}}
                <div class="form-group">
                    <label for="certification_vendor_id">Vendor Sertifikasi</label>
                    <select name="certification_vendor_id" id="certification_vendor_id" class="form-control" required>
                        <option value="">- Pilih Vendor Sertifikasi -</option>
                        @foreach ($vendor as $v)
                        <option value="{{ $v['certification_vendor_id'] }}" {{ $v['certification_vendor_id']==$certification['certification_vendor_id'] ? 'selected' : '' }}>
                            {{ $v['certification_vendor_name'] }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-certification_vendor_id" class="error-text form-text text-danger"></small>
                </div>

                {{-- Tipe Sertifikasi --}}
                <div class="form-group">
                    <label for="certification_type_id">Tipe Sertifikasi</label>
                    <select name="certification_type_id" id="certification_type_id" class="form-control" required>
                        <option value="">- Pilih Tipe Sertifikasi -</option>
                        @foreach ($type as $t)
                        <option value="{{ $t['certification_type_id'] }}" {{ $t['certification_type_id']==$certification['certification_type_id'] ? 'selected' : '' }}>
                            {{ $t['certification_type_name'] }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-certification_type_id" class="error-text form-text text-danger"></small>
                </div>

                {{-- Level Sertifikasi --}}
                <div class="form-group">
                    <label for="certification_level_id">Level Sertifikasi</label>
                    <select name="certification_level_id" id="certification_level_id" class="form-control" required>
                        <option value="">- Pilih Level Sertifikasi -</option>
                        @foreach ($level as $l)
                        <option value="{{ $l['certification_level_id'] }}" {{ $l['certification_level_id']==$certification['certification_level_id'] ? 'selected' : '' }}>
                            {{ $l['certification_level_name'] }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-certification_level_id" class="error-text form-text text-danger"></small>
                </div>

                {{-- Mata Kuliah --}}
                <div class="form-group">
                    <label for="course_id">Vendor Sertifikasi</label>
                    <select name="course_id" id="course_id" class="form-control" required>
                        <option value="">- Pilih Mata Kuliah -</option>
                        @foreach ($course as $c)
                        <option value="{{ $c['course_id'] }}" {{ $c['course_id']==$certification['course_id'] ? 'selected' : '' }}>
                            {{ $c['course_name'] }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-course_id" class="error-text form-text text-danger"></small>
                </div>

                {{-- Bidang Minat --}}
                <div class="form-group">
                    <label for="interest_id">Bidang Minat</label>
                    <select name="interest_id" id="interest_id" class="form-control" required>
                        <option value="">- Pilih Bidang Minat -</option>
                        @foreach ($interest as $i)
                        <option value="{{ $i['interest_id'] }}" {{ $i['interest_id']==$certification['interest_id'] ? 'selected' : '' }}>
                            {{ $i['interest_name'] }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-interest_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="certification_name">Nama Sertifikasi</label>
                    <input value="{{ old('certification_name', $certification['certification_name']) }}" type="text" name="certification_name" id="certification_name"
                        class="form-control" required>
                    <small id="error-certification_name" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="certification_number">Nomor Sertifikasi</label>
                    <input value="{{ old('certification_number', $certification['certification_number']) }}" type="text" name="certification_number" id="certification_number"
                        class="form-control" required>
                    <small id="error-certification_number" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="certification_date">Tanggal Sertifikasi</label>
                    <input value="{{ old('certification_date', $certification['certification_date']) }}" type="datetime-local" name="certification_date" id="certification_date"
                        class="form-control" required>
                    <small id="error-certification_date" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="certification_expired">Tenggat Sertifikasi</label>
                    <input value="{{ old('certification_expired', $certification['certification_expired']) }}" type="datetime-local" name="certification_expired" id="certification_expired"
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
@endempty