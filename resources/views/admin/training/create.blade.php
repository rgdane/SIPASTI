
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

</style>
@endpush

<form action="{{ url('/training/store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
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

                <!-- Level Pelatihan -->
                <div class="form-group">
                    <label for="training_level">Level Pelatihan</label>
                    <select name="training_level" id="training_level" class="form-control" required>
                        <option value="">- Pilih Level Pelatihan -</option>
                        <option value="0">Nasional</option>
                        <option value="1">Internasional</option>
                    </select>
                    <small id="error-training_level" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Vendor Pelatihan -->
                <div class="form-group">
                    <label for="training_vendor_id">Vendor Pelatihan</label>
                    <select name="training_vendor_id" id="training_vendor_id" class="form-control" required>
                        <option value="">- Pilih Vendor -</option>
                        @foreach($training_vendor as $l) <option value="{{ $l->training_vendor_id }}">{{ $l->training_vendor_name }}</option> @endforeach
                    </select>
                    <small id="error-training_vendor_id" class="error-text form-text text-danger"></small>
                </div>
                
                <!-- Nama Pelatihan -->
                <div class="form-group">
                    <label for="training_name">Nama Pelatihan</label>
                    <input value="" type="text" name="training_name" id="training_name" class="form-control"
                        required>
                    <small id="error-training_name" class="error-text form-text text-danger"></small>
                </div>

                <!-- Periode Pelatihan -->
                <div class="form-group">
                    <label for="period_id">Tahun Periode</label>
                    <select name="period_id" id="period_id" class="form-control" required>
                        <option value="">- Pilih Periode -</option>
                        @foreach($period as $l) <option value="{{ $l->period_id }}">{{ $l->period_year }}</option> @endforeach
                    </select>
                    <small id="error-period_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Pelatihan -->
                <div class="form-group">
                    <label for="training_date">Tanggal Pelatihan</label>
                    <input type="date" class="form-control" id="training_date" name="training_date" 
                            value="{{ date('Y-m-d') }}">
                    <small id="error-training_date" class="error-text form-text text-danger"></small>
                </div>

                <!-- Durasi Pelatihan -->
                <div class="form-group">
                    <label for="training_hours">Durasi Pelatihan (jam)</label>
                    <input value="" type="number" name="training_hours" id="training_hours"
                        class="form-control" required>
                    <small id="error-training_hours" class="error-text form-text text-danger"></small>
                </div>

                <!-- Durasi Pelatihan -->
                <div class="form-group">
                    <label for="training_location">Lokasi Pelatihan</label>
                    <input value="" type="text" name="training_location" id="training_location"
                        class="form-control" required>
                    <small id="error-training_location" class="error-text form-text text-danger"></small>
                </div>

                <!-- Durasi Pelatihan -->
                <div class="form-group">
                    <label for="training_cost">Biaya Pelatihan (Rp)</label>
                    <input value="" type="number" name="training_cost" id="training_cost"
                        class="form-control" required>
                    <small id="error-training_cost" class="error-text form-text text-danger"></small>
                </div>

                <!-- Durasi Pelatihan -->
                <div class="form-group">
                    <label for="training_quota">Kuota Pelatihan</label>
                    <input value="" type="number" name="training_quota" id="training_quota"
                        class="form-control" required>
                    <small id="error-training_quota" class="error-text form-text text-danger"></small>
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

                <!-- Status Pelatihan -->
                <div class="form-group">
                    <label for="training_status">Status Pelatihan</label>
                    <select name="training_status" id="training_status" class="form-control" required>
                        <option value="">- Pilih Status Pelatihan -</option>
                        <option value="1">Pengajuan</option>
                        <option value="4">Selesai</option>
                    </select>
                    <small id="error-training_status" class="error-text form-text text-danger"></small>
                </div>

                <div id="user-container">
                    <label>Peserta Pelatihan</label>
                    <div class="form-row user-item">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="user_id[]" class="form-control user-select" data-id="user-select">
                                    <option value="">- Pilih Peserta -</option>
                                    @foreach($user as $a)
                                        <option value="{{ $a->user_id }}">{{ $a->user_fullname }}</option>
                                    @endforeach
                                </select>
                                <small id="error-user_id" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
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
    $(document).ready(function () {
        // Inisialisasi Select2
        $('#course_id').select2({
            placeholder: "- Pilih Mata Kuliah -",
            allowClear: true,
            width: '100%',
        });
        $('#interest_id').select2({
            placeholder: "- Pilih Bidang Minat -",
            allowClear: true,
            width: '100%',
        });

        let selectedUserIds = []; // Array untuk menyimpan ID yang dipilih

        // Fungsi untuk memperbarui dropdown user
        function updateDropdownOptions() {
            $('.user-select').each(function () {
                let currentSelect = $(this);
                currentSelect.find('option').each(function () {
                    let option = $(this);
                    if (option.val() && selectedUserIds.includes(option.val())) {
                        // Sembunyikan opsi jika sudah dipilih
                        if (!currentSelect.val() || currentSelect.val() !== option.val()) {
                            option.hide();
                        }
                    } else {
                        // Tampilkan opsi yang belum dipilih
                        option.show();
                    }
                });
            });
        }

        // Fungsi untuk menambahkan kolom peserta baru
        function tambahKolomPeserta() {
            let newItem = $('.user-item:first').clone();
            newItem.find('select').val(''); // Kosongkan nilai select
            newItem.find('.error-text').text(''); // Hapus error text
            $('#user-container').append(newItem);
            updateDropdownOptions(); // Perbarui dropdown setelah kolom baru ditambahkan
        }

        // Fungsi untuk menghapus kolom peserta terakhir
        function hapusKolomPeserta() {
            if ($('.user-item').length > 1) {
                let lastSelect = $('.user-item:last').find('select');
                let lastValue = lastSelect.val();

                // Hapus ID dari array jika sudah dipilih
                if (lastValue) {
                    selectedUserIds = selectedUserIds.filter(id => id !== lastValue);
                }

                $('.user-item:last').remove();
                updateDropdownOptions(); // Perbarui dropdown setelah kolom dihapus
            }
        }

        // Event listener untuk perubahan pada input kuota
        $('#training_quota').on('change', function () {
            let quota = parseInt($(this).val()) || 0;
            let currentCount = $('.user-item').length;

            if (quota > currentCount) {
                for (let i = currentCount; i < quota; i++) {
                    tambahKolomPeserta();
                }
            } else if (quota < currentCount) {
                for (let i = currentCount; i > quota; i--) {
                    hapusKolomPeserta();
                }
            }
        });

        // Event listener untuk perubahan pilihan dropdown
        $(document).on('change', '.user-select', function () {
            let selectedValue = $(this).val();

            if (selectedValue) {
                // Tambahkan ID ke array jika dipilih
                if (!selectedUserIds.includes(selectedValue)) {
                    selectedUserIds.push(selectedValue);
                }
            }

            updateDropdownOptions(); // Perbarui semua dropdown
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
                    if (typeof dataTraining !== 'undefined') {
                        dataTraining.ajax.reload();
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
    