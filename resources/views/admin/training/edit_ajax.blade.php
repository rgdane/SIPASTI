@empty($training)
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
            <a href="{{ url('/training') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/training/' . $training['training_id'] . '/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Vendor Pelatihan --}}
                <div class="form-group">
                    <label for="training_vendor_id">Vendor Pelatihan</label>
                    <select name="training_vendor_id" id="training_vendor_id" class="form-control" required>
                        <option value="">- Pilih Vendor Pelatihan -</option>
                        @foreach ($vendor as $v)
                        <option value="{{ $v['training_vendor_id'] }}" {{ $v['training_vendor_id']==$training['training_vendor_id'] ? 'selected' : '' }}>
                            {{ $v['training_vendor_name'] }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-training_vendor_id" class="error-text form-text text-danger"></small>
                </div>

                {{-- Tipe Pelatihan --}}
                <div class="form-group">
                    <label for="training_type_id">Tipe Pelatihan</label>
                    <select name="training_type_id" id="training_type_id" class="form-control" required>
                        <option value="">- Pilih Tipe Pelatihan -</option>
                        @foreach ($type as $t)
                        <option value="{{ $t['training_type_id'] }}" {{ $t['training_type_id']==$training['training_type_id'] ? 'selected' : '' }}>
                            {{ $t['training_type_name'] }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-training_type_id" class="error-text form-text text-danger"></small>
                </div>

                {{-- Mata Kuliah --}}
                <div class="form-group">
                    <label for="course_id">Mata Kuliah</label>
                    <select name="course_id" id="course_id" class="form-control" required>
                        <option value="">- Pilih Mata Kuliah -</option>
                        @foreach ($course as $c)
                        <option value="{{ $c['course_id'] }}" {{ $c['course_id']==$training['course_id'] ? 'selected' : '' }}>
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
                        <option value="{{ $i['interest_id'] }}" {{ $i['interest_id']==$training['interest_id'] ? 'selected' : '' }}>
                            {{ $i['interest_name'] }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-interest_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="training_name">Nama Pelatihan</label>
                    <input value="{{ old('training_name', $training['training_name']) }}" type="text" name="training_name" id="training_name"
                        class="form-control" required>
                    <small id="error-training_name" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="training_date">Tanggal Pelatihan</label>
                    <input value="{{ old('training_date', $training['training_date']) }}" type="datetime-local" name="training_date" id="training_date"
                        class="form-control" required>
                    <small id="error-training_date" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="training_location">Lokasi Pelatihan</label>
                    <input value="{{ old('training_location', $training['training_location']) }}" type="text" name="training_location" id="training_location"
                        class="form-control" required>
                    <small id="error-training_location" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="training_cost">Biaya Pelatihan</label>
                    <input value="{{ old('training_cost', $training['training_cost']) }}" type="number" name="training_cost" id="training_cost"
                        class="form-control" required>
                    <small id="error-training_cost" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="training_quota">Kuota Pelatihan</label>
                    <input value="{{ old('training_quota', $training['training_quota']) }}" type="number" name="training_quota" id="training_quota"
                        class="form-control" required>
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
            $("#form-edit").validate({
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
@endempty