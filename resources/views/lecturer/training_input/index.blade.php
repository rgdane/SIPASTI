@extends('layouts.template')

@section('content')
<div class="container-fluid px-4">
    <div class="header-border"></div>
    <br><br>

    <div class="mt-2">
        <form action="{{ url('/training_input/'. $userId. '/store') }}" method="POST" id="form-input"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Nama Pelatihan --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Nama Pelatihan</label>
                    <input type="text" class="form-control" id="training_name" name="training_name"
                        placeholder="Masukkan nama pelatihan" required>
                </div>

                {{-- Tanggal Pelatihan --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Tanggal Pelatihan</label>
                    <input type="date" class="form-control" id="training_date" name="training_date" required>
                </div>

                {{-- Durasi Pelatihan --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Durasi Pelatihan (jam)</label>
                    <input type="number" class="form-control" id="training_hours" name="training_hours"
                        placeholder="Masukkan durasi pelatihan" required>
                </div>

                <!-- Tahun Periode -->
                <div class="col-md-6 mb-4">
                    <label for="period">Tahun Periode</label>
                    <select name="period_id" id="period_id" class="form-control" required>
                        <option value="">- Pilih Periode -</option>
                        @foreach($periode as $l) <option value="{{ $l->period_id }}">{{ $l->period_year }}</option>
                        @endforeach
                    </select>
                    <small id="error-period" class="error-text form-text text-danger"></small>
                </div>

                {{-- Biaya Pelatihan --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Biaya Pelatihan (Rp)</label>
                    <input type="number" class="form-control" id="training_cost" name="training_cost"
                        placeholder="Masukkan biaya pelatihan" required>
                </div>

                {{-- Lokasi Pelatihan --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Lokasi Pelatihan</label>
                    <input type="text" class="form-control" id="training_location" name="training_location"
                        placeholder="Masukkan lokasi pelatihan" required>
                </div>

                {{-- Level Pelatihan --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Level Pelatihan</label>
                    <select class="form-control" name="training_level" id="training_level" required>
                        <option value="">- Pilih Level Pelatihan -</option>
                        <option value="0">Nasional</option>
                        <option value="1">Internasional</option>
                    </select>
                </div>

                {{-- Vendor Pelatihan --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Lembaga Penyelenggara</label>
                    <select class="form-control" id="training_vendor_id" name="training_vendor_id">
                        <option value="">-- Pilih Lembaga Penyelenggara --</option>
                        @foreach($training_vendor as $l)
                        <option value="{{ $l->training_vendor_id }}">{{ $l->training_vendor_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Mata Kuliah --}}
                <div class="col-md-6 mb-4">
                    <label for="course_id">Mata Kuliah</label><br>
                    <select name="course_id[]" id="course_id" class="form-control " multiple required>
                        @foreach($course as $l)
                        <option value="{{ $l->course_id }}">{{ $l->course_name }}</option>
                        @endforeach
                    </select>
                    <small id="error-course_id" class="error-text form-text text-danger"></small>
                </div>

                {{-- Bidang Minat --}}
                <div class="col-md-6 mb-4">
                    <label for="interest_id">Bidang Minat</label>
                    <select name="interest_id[]" id="interest_id" class="form-control select2-multiple" multiple
                        required>
                        @foreach($interest as $l)
                        <option value="{{ $l->interest_id }}">{{ $l->interest_name }}</option>
                        @endforeach
                    </select>
                    <small id="error-interest_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Submit Button -->
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

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

    /* Ensure selected items have black text */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #2C3941;
        border: 1px solid #ddd;
        color: #000 !important;
        /* Force black text color */
    }

    /* Ensure the selection text is black */
    .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
        color: #ffffff !important;
        /* Force black text color */
    }

    /* Submit Button Styling */
    .btn-primary {
        padding: 0.5rem 2rem;
        font-weight: 500;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#course_id').select2({
            placeholder: "Pilih Mata Kuliah",
            allowClear: true,
            minimumResultsForSearch: 5,
            width: '100%',
            templateResult: function(state) {
                if (!state.id) { return state.text; }
                return $('<span>' + state.text + '</span>');
            },
            templateSelection: function(state) {
                if (!state.id) { return state.text; }
                return $('<span>' + state.text + '</span>');
            }
        });

        $('#interest_id').select2({
            placeholder: "Pilih Bidang Minat",
            allowClear: true,
            minimumResultsForSearch: 5,
            width: '100%',
            templateResult: function(state) {
                if (!state.id) { return state.text; }
                return $('<span>' + state.text + '</span>');
            },
            templateSelection: function(state) {
                if (!state.id) { return state.text; }
                return $('<span>' + state.text + '</span>');
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
    $('#form-input').on('submit', function(e) {
        e.preventDefault();

        // Simpan referensi form
        let form = this;

        $.ajax({
            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: new FormData(form),
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

                    // Reset form
                    form.reset();

                    // Reset Select2
                    $('#course_id').val(null).trigger('change');
                    $('#interest_id').val(null).trigger('change');
                } else {
                    // Tampilkan pesan kesalahan
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });

                    // Tampilkan error field
                    $('.error-text').text(''); // Bersihkan error sebelumnya
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
@endpush