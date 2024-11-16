@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <!-- Minimalist Header Navigation -->
    <div class="header-nav">
        <a href="{{ url('/certification_input') }}" class="nav-link">Sertifikasi Mandiri</a>
        <a href="{{ url('/certification_upload') }}" class="nav-link active">Upload Sertifikasi</a>
    </div>
    <div class="header-border"></div>

    <!-- Upload Section -->
    <div class="mt-4">
        <h5>Upload Sertifikasi</h5>
        
        <div class="upload-container">
            <form action="{{ url('/certification_upload/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="upload-area">
                    <h6 class="text-center mb-2">Upload Sertifikasi Anda</h6>
                    <p class="text-center text-muted small mb-4">Pilih dokumen yang relevan untuk melengkapi sertifikasi Anda</p>
                    
                    <div class="upload-box">
                        <div class="upload-content">
                            <img src="{{ asset('image/cloud-computing.png') }}" alt="Upload" class="upload-icon mb-3">
                            <p class="text-muted mb-1">Pilih file atau seret dan lepas di sini</p>
                            <p class="text-muted small">.JPG, .PNG, .PDF, .JPEG file kurang dari 10MB</p>
                            <button type="button" class="btn btn-light mt-3" onclick="document.getElementById('file-upload').click()">
                                Pilih File
                            </button>
                            <input type="file" id="file-upload" name="certification_file" class="d-none" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                    </div>

                    <div class="button-group mt-4">
                        <button type="button" class="btn btn-warning px-4">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
/* Header Styling */
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

/* Button Group Styling */
.button-group {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.btn-warning {
    background-color: #ffc107;
    border: none;
    color: #000;
}

.btn-primary {
    background-color: #0d6efd;
    border: none;
}

/* Text Styling */
h6 {
    font-weight: 500;
}

.text-muted {
    color: #6c757d !important;
}

.small {
    font-size: 0.875rem;
}
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadBox = document.querySelector('.upload-box');
    const fileInput = document.getElementById('file-upload');
    
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
            // You can add code here to show the selected file name
        }
    });
    
    // Handle click upload
    uploadBox.addEventListener('click', () => {
        fileInput.click();
    });
    
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length) {
            // You can add code here to show the selected file name
        }
    });
});
</script>
@endpush