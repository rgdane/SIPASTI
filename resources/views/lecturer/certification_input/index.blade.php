@extends('layouts.template')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Navigation - Styled as pills instead of tabs -->
    <!-- Minimalist Header Navigation -->
    {{-- <div class="header-nav">
        <a href="{{ url('/certification_input') }}" class="nav-link active">Sertifikasi Mandiri</a>
        <a href="{{ url('/certification_upload')}}" class="nav-link">Upload Sertifikasi</a>
    </div> --}}
    <div class="header-border"></div> <br><br>

    <!-- Form tanpa card, langsung di container -->
    <div class="mt-2">
        <form action="{{ url('/certification_input/' . $userId . '/store') }}" method="POST" id="form-input"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Nama Sertifikasi -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Nama Sertifikasi</label>
                    <input type="text" class="form-control" id="certification_name" name="certification_name"
                        placeholder="Masukkan nama sertifikasi">
                </div>

                <!-- Waktu Pelaksanaan -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Waktu Mulai Berlaku</label>
                    <input type="date" class="form-control" id="certification_date_start"
                        name="certification_date_start" value="{{ date('Y-m-d') }}">
                </div>

                <!-- Mandiri/Non Mandiri -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Nomor Sertifikasi</label>
                    <input type="text" class="form-control" id="certification_number" name="certification_number"
                        placeholder="Masukkan nomor sertifikasi">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Waktu Akhir Berlaku</label>
                    <input type="date" class="form-control" id="certification_date_expired"
                        name="certification_date_expired" value="{{ date('Y-m-d') }}">
                </div>

                <!-- Lembaga Penyelenggara -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Lembaga Penyelenggara</label>
                    <select class="form-control" id="certification_vendor_id" name="certification_vendor_id">
                        <option value="">-- Pilih Lembaga Penyelenggara --</option>
                        @foreach($certification_vendor as $l)
                        <option value="{{ $l->certification_vendor_id }}">{{ $l->certification_vendor_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Level Sertifikasi -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Level Sertifikasi</label>
                    <select class="form-control" id="certification_level" name="certification_level">
                        <option value="">-- Pilih Level Sertifikasi --</option>
                        <!-- Opsi jenis sertifikasi dari backend -->
                        <option value="0">Nasional</option>
                        <option value="1">Internasional</option>
                    </select>
                </div>

                <!-- Jenis Sertifikasi -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Jenis Sertifikasi</label>
                    <select class="form-control" id="certification_type" name="certification_type">
                        <option value="">-- Pilih Jenis Sertifikasi --</option>
                        <!-- Opsi jenis sertifikasi dari backend -->
                        <option value="0">Profesi</option>
                        <option value="1">Keahlian</option>
                    </select>
                </div>

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

                <!-- Mata Kuliah -->
                <div class="col-md-6 mb-4">
                    <label for="course_id">Mata Kuliah</label><br>
                    <select name="course_id[]" id="course_id" class="form-control " multiple required>
                        @foreach($course as $l)
                        <option value="{{ $l->course_id }}">{{ $l->course_name }}</option>
                        @endforeach
                    </select>
                    <small id="error-course_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Nomor Sertifikasi -->
                <div class="col-md-6 mb-4">
                    <label for="period">Tahun Periode</label>
                    <select name="period_id" id="period_id" class="form-control" required>
                        <option value="">- Pilih Periode -</option>
                        @foreach($periode as $l) <option value="{{ $l->period_id }}">{{ $l->period_year }}</option> @endforeach
                    </select>
                    <small id="error-period" class="error-text form-text text-danger"></small>
                </div>

                <!-- Upload Dokumen = -->
                <div class="upload-container">
                    <div class="upload-area">
                        <h6 class="text-center mb-2">Upload Dokumen Sertifikasi Anda</h6>
                        <p class="text-center text-muted small mb-4">Pilih dokumen yang relevan untuk melengkapi
                            sertifikasi Anda</p>

                        <div class="upload-box">
                            <div class="upload-content">
                                <img src="{{ asset('image/cloud-computing.png') }}" alt="Upload"
                                    class="upload-icon mb-3">
                                <p class="text-muted mb-1">Pilih file atau seret dan lepas di sini</p>
                                <p class="text-muted small">.JPG, .PNG, .PDF, .JPEG file kurang dari 10MB</p>
                                <button type="button" class="btn btn-light mt-3"
                                    onclick="document.getElementById('file-upload').click()">
                                    Pilih File
                                </button>
                                <input type="file" id="file-upload" name="certification_file" class="d-none"
                                    accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                        </div>
                    </div>
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
});

document.addEventListener('DOMContentLoaded', function() {
    const uploadBox = document.querySelector('.upload-box');
    const fileInput = document.getElementById('file-upload');
    const uploadContent = document.querySelector('.upload-content');

    // Handle drag and drop
    uploadBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadBox.style.borderColor = '#0d6efd';
    });
    
    uploadBox.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadBox.style.borderColor = '#dee2e6';
    });
    
    uploadBox.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadBox.style.borderColor = '#dee2e6';
        
        const files = e.dataTransfer.files;
        if (files.length) {
            fileInput.files = files;
            updateFileDisplay(files[0]);
        }
    });
    
    // Handle click upload
    uploadBox.addEventListener('click', () => {
        fileInput.click();
    });
    
    // Handle file selection
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length) {
            updateFileDisplay(e.target.files[0]);
        }
    });

    // Function to update file display
    function updateFileDisplay(file) {
        // Create file info element if it doesn't exist
        let fileInfoElement = document.querySelector('.file-info');
        if (!fileInfoElement) {
            fileInfoElement = document.createElement('div');
            fileInfoElement.classList.add('file-info', 'text-center', 'mt-3');
            uploadContent.appendChild(fileInfoElement);
        }

        // Display file name and size
        fileInfoElement.innerHTML = `
            <p class="mb-1"><strong>File Terpilih:</strong> ${file.name}</p>
            <p class="text-muted small">${formatFileSize(file.size)}</p>
        `;
    }

    // Function to format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endpush