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
<form action="{{ url('/certification/' . $certification->certification_id . '/update') }}" method="POST" id="form-edit">
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
                <!-- Vendor Sertifikasi -->
                <div class="form-group">
                    <label for="user_id">Nama Pengguna</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih Pengguna -</option>
                        @foreach($user as $l) <option value="{{ $l->user_id }}" {{$l->user_id == $certification->user_id ? 'selected' : ''}}>
                            {{ $l->user_fullname }}</option> @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tipe Seritifikasi -->
                <div class="form-group">
                    <label for="certification_type">Tipe Sertifikasi</label>
                    <select name="certification_type" id="certification_type" class="form-control" required>
                        <option value="">- Pilih Tipe Sertifikasi -</option>
                        <option value="0" {{'Profesi' == $certification->certification_type ? 'selected' : ''}}>Profesi</option>
                        <option value="1" {{'Keahlian' == $certification->certification_type ? 'selected' : ''}}>Keahlian</option>
                    </select>
                    <small id="error-certification_type_id" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Level Seritifikasi -->
                <div class="form-group">
                    <label for="certification_level">Level Sertifikasi</label>
                    <select name="certification_level" id="certification_level" class="form-control" required>
                        <option value="">- Pilih Level Sertifikasi -</option>
                        <option value="0" {{'Nasional' == $certification->certification_level ? 'selected' : ''}}>Nasional</option>
                        <option value="1" {{'Internasional' == $certification->certification_level ? 'selected' : ''}}>Internasional</option>
                    </select>
                    <small id="error-certification_level_id" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Vendor Sertifikasi -->
                <div class="form-group">
                    <label for="certification_vendor_id">Vendor Sertifikasi</label>
                    <select name="certification_vendor_id" id="certification_vendor_id" class="form-control" required>
                        <option value="">- Pilih Vendor -</option>
                        @foreach($certification_vendor as $l)
                        <option value="{{ $l->certification_vendor_id }}" {{ $l->certification_vendor_id == $certification->certification_vendor_id ? 'selected' : '' }}>
                            {{ $l->certification_vendor_name }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-certification_vendor_id" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Nama Sertifikasi -->
                <div class="form-group">
                    <label for="certification_name">Nama Sertifikasi</label>
                    <input value="{{ old('certification_name', $certification->certification_name) }}" type="text" name="certification_name" id="certification_name" class="form-control"
                        required>
                    <small id="error-certification_name" class="error-text form-text text-danger"></small>
                </div>

                <!-- Nomor Sertifikasi -->
                <div class="form-group">
                    <label for="certification_number">Nomor Sertifikasi</label>
                    <input value="{{ old('certification_number', $certification->certification_number) }}" type="text" name="certification_number" id="certification_number"
                        class="form-control" required>
                    <small id="error-certification_number" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Nomor Sertifikasi -->
                <div class="form-group">
                    <label for="period">Tahun Periode</label>
                    <select name="period_id" id="period_id" class="form-control" required>
                        <option value="">- Pilih Periode -</option>
                        @foreach($period as $l)
                        <option value="{{ $l->period_id }}" {{ $l->period_id == $certification->period_id ? 'selected' : '' }}>
                            {{ $l->period_year }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-period" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Sertifikasi -->
                <div class="form-group">
                    <label for="certification_date_start">Tanggal Mulai Berlaku</label>
                    <input type="date" class="form-control" id="certification_date_start" name="certification_date_start"
                        value="{{ old('certification_date_start', date('Y-m-d', strtotime($certification->certification_date_start ?? ''))) }}">

                    <small id="error-certification_date_start" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tenggat Sertifikasi -->
                <div class="form-group">
                    <label for="certification_date_expired">Tanggal Akhir Berlaku</label>
                    <input type="date" class="form-control" id="certification_date_expired" name="certification_date_expired" 
                        value="{{ old('certification_date_expired', date('Y-m-d', strtotime($certification->certification_date_expired ?? ''))) }}">
                    <small id="error-certification_date_expired" class="error-text form-text text-danger"></small>
                </div>

                <!-- Mata Kuliah -->
                <div class="form-group">
                    <label for="course_id">Mata Kuliah</label><br>
                    <select name="course_id[]" id="course_id" class="form-control" multiple required>
                        @foreach($course as $l)
                            <option value="{{ $l->course_id }}"
                                @foreach ($courseCertification as $c)
                                    {{$l->course_id == $c->course_id ? 'selected' : ''}}
                                @endforeach >
                                {{ $l->course_name }}
                            </option> 
                        @endforeach
                    </select>
                    <small id="error-course_id" class="error-text form-text text-danger"></small>
                </div>


                <!-- Bidang Minat -->
                <div class="form-group">
                    <label for="interest_id">Bidang Minat</label><br>
                    <select name="interest_id[]" id="interest_id" class="form-control" multiple required>
                        @foreach($interest as $l)
                            <option value="{{ $l->interest_id }}"
                                @foreach ($interestCertification as $c)
                                    {{$l->interest_id == $c->interest_id ? 'selected' : ''}}
                                @endforeach >
                                {{ $l->interest_name }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-interest_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Upload Dokumen -->
                    <div class="upload-area">
                        <div class="form-group">
                            <label>Upload Dokumen</label>
                            <h6 class="text-muted"> (Abaikan jika tidak ingin mengganti dokumen) </h6>
                            <input type="file" name="certification_file" id="certification_file" class="form-control">
                            <small id="error-certification_file" class="error-text form-text text-danger"></small>
                        </div>
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
        $('#course_id').select2({
            placeholder: "- Pilih Mata Kuliah -",
            allowClear: true
        });
        $('#interest_id').select2({
            placeholder: "- Pilih Bidang Minat -",
            allowClear: true
        });
    });
    // Form submission handling
    $('#form-edit').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    // Tampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    });

                    // Tutup modal
                    $('#myModal').modal('hide');

                    // Refresh data table (jika ada)
                    if (typeof dataCertification !== 'undefined') {
                        dataCertification.ajax.reload();
                    }
                } else {
                    // Tampilkan pesan kesalahan
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });

                    // Tampilkan error field
                    $('.error-text').text('');
                    $.each(response.msgField, function(prefix, val) {
                        $('#error-' + prefix).text(val[0]);
                    });
                }
            },
            error: function(xhr) {
                // Tangani error server
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Silakan coba lagi nanti.'
                });
                console.error(xhr.responseText);
            }
        });
    });
    
</script>
@endempty