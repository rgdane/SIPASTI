
@stack('css')

@push('css')
<style>
/* Minimalist Header Styling */
.header-nav {
    display: flex;
    gap: 32px;
    padding: 8px 0;
}

.nav-link {
    color: #666;
    text-decoration: none;
    position: relative;
}

.nav-link.active {
    color: #000;
    font-weight: 500;
}

.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #000;
}

.header-border {
    width: 100%;
    height: 1px;
    background-color: #e0e0e0;
    margin-bottom: 16px;
}

/* Form Styling */
.form-label {
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control {
    padding: 0.5rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.form-control::placeholder {
    color: #999;
    font-size: 0.9rem;
}

/* Submit Button Styling */
.btn-primary {
    padding: 0.5rem 2rem;
    font-weight: 500;
}

/* Upload Area Styling */
.upload-container {
    max-width: 600px;
    margin: 2rem auto;
}

.upload-area {
    padding: 2rem;
}

.upload-box {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 3rem 2rem;
    text-align: center;
    background-color: #f8f9fa;
    cursor: pointer;
    transition: border-color 0.3s ease;
}

.upload-box:hover {
    border-color: #0d6efd;
}

.upload-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.upload-icon {
    width: 64px;
    height: 64px;
    opacity: 0.6;
}
</style>
@endpush

<form action="{{ url('/certification/store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
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
                    <label for="user_id">Nama Pengguna</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih Pengguna -</option>
                        @foreach($user as $l) <option value="{{ $l->user_id }}">{{ $l->user_fullname }}</option> @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tipe Seritifikasi -->
                <div class="form-group">
                    <label for="certification_type">Tipe Sertifikasi</label>
                    <select name="certification_type" id="certification_type" class="form-control" required>
                        <option value="">- Pilih Tipe Sertifikasi -</option>
                        <option value="0">Profesi</option>
                        <option value="1">Keahlian</option>
                    </select>
                    <small id="error-certification_type_id" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Level Seritifikasi -->
                <div class="form-group">
                    <label for="certification_level">Level Sertifikasi</label>
                    <select name="certification_level" id="certification_level" class="form-control" required>
                        <option value="">- Pilih Level Sertifikasi -</option>
                        <option value="0">Nasional</option>
                        <option value="1">Internasional</option>
                    </select>
                    <small id="error-certification_level_id" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Vendor Sertifikasi -->
                <div class="form-group">
                    <label for="certification_vendor_id">Vendor Sertifikasi</label>
                    <select name="certification_vendor_id" id="certification_vendor_id" class="form-control" required>
                        <option value="">- Pilih Vendor -</option>
                        @foreach($certification_vendor as $l) <option value="{{ $l->certification_vendor_id }}">{{ $l->certification_vendor_name }}</option> @endforeach
                    </select>
                    <small id="error-certification_vendor_id" class="error-text form-text text-danger"></small>
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
                
                <!-- Nomor Sertifikasi -->
                <div class="form-group">
                    <label for="period">Tahun Periode</label>
                    <select name="period_id" id="period_id" class="form-control" required>
                        <option value="">- Pilih Periode -</option>
                        @foreach($period as $l) <option value="{{ $l->period_id }}">{{ $l->period_year }}</option> @endforeach
                    </select>
                    <small id="error-period" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Sertifikasi -->
                <div class="form-group">
                    <label for="certification_date_start">Tanggal Mulai Berlaku</label>
                    <input type="date" class="form-control" id="certification_date_start" name="certification_date_start" 
                            value="{{ date('Y-m-d') }}">
                    <small id="error-certification_date_start" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tenggat Sertifikasi -->
                <div class="form-group">
                    <label for="certification_date_expired">Tanggal Akhir Berlaku</label>
                    <input type="date" class="form-control" id="certification_date_expired" name="certification_date_expired" 
                            value="{{ date('Y-m-d') }}">
                    <small id="error-certification_date_expired" class="error-text form-text text-danger"></small>
                </div>

                <!-- Mata Kuliah -->
                <div class="form-group">
                    <label for="course_id">Mata Kuliah</label><br>
                    <select name="course_id[]" id="course_id" class="form-control" multiple required>
                        @foreach($course as $l) 
                            <option value="{{ $l->course_id }}">{{ $l->course_name }}</option> 
                        @endforeach
                    </select>
                    <small id="error-course_id" class="error-text form-text text-danger"></small>
                </div>


                <!-- Bidang Minat -->
                <div class="form-group">
                    <label for="interest_id">Bidang Minat</label><br>
                    <select name="interest_id[]" id="interest_id" class="form-control" multiple required>
                        @foreach($interest as $l) 
                            <option value="{{ $l->interest_id }}">{{ $l->interest_name }}</option> 
                        @endforeach
                    </select>
                    <small id="error-interest_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Upload Dokumen -->
                <div class="upload-area">
                    <div class="form-group">
                        <label>Upload Dokumen</label>
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
    $('#form-tambah').on('submit', function(e) {
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
    