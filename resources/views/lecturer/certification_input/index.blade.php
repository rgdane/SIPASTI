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
        <form action="{{ url('/certification_input/' . $userId . '/store') }}" method="POST" id="form-input" enctype="multipart/form-data">
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
                    <input type="date" class="form-control" id="certification_date_start" name="certification_date_start" 
                            value="{{ date('Y-m-d') }}">
                </div>
            
                <!-- Mandiri/Non Mandiri -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Nomor Sertifikasi</label>
                    <input type="text" class="form-control" id="certification_number" name="certification_number"
                            placeholder="Masukkan nomor sertifikasi">
                </div>
            
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Waktu Akhir Berlaku</label>
                    <input type="date" class="form-control" id="certification_date_expired" name="certification_date_expired" 
                            value="{{ date('Y-m-d') }}">
                </div>

                <!-- Bidang Minat -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Bidang Minat</label>
                    <div class="tags-input-wrapper">
                        <div class="tags-container">
                            <ul class="tags-list"></ul>
                            <input type="text" class="tag-input" id="bidang_minat" name="bidang_minat[]" 
                                    placeholder="Masukkan bidang minat dan tekan Enter">
                        </div>
                    </div>
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
            
                <!-- Mata Kuliah - Full width -->
                <div class="col-12 mb-4">
                    <label class="form-label mb-2">Mata Kuliah</label>
                    <input type="text" class="form-control" id="course" name="course" 
                            placeholder="Masukkan mata kuliah">
                </div>

                <!-- Upload Dokumen = -->
                <div class="upload-container">
                    <div class="upload-area">
                        <h6 class="text-center mb-2">Upload Dokumen Sertifikasi Anda</h6>
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

/* Tags Input Styling */
.tags-input-wrapper {
    width: 100%;
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 4px;
    min-height: 38px;
    padding: 4px 8px;
}

.tags-container {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    align-items: center;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    padding: 0;
    margin: 0;
    list-style: none;
}

.tag-item {
    background: #e9ecef;
    border-radius: 4px;
    padding: 2px 8px;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.9rem;
}

.tag-input {
    border: none;
    outline: none;
    flex: 1;
    padding: 4px;
    font-size: 0.9rem;
    min-width: 60px;
}

.remove-tag-btn {
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    padding: 0 2px;
    font-size: 1.1rem;
    line-height: 1;
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
// $(document).ready(function() {
//         $("#form-input").validate({
//             rules: {
//                 certification_vendor_id: {
//                     required: true
//                 },
//                 certification_type: {
//                     required: true
//                 },
//                 certification_level: {
//                     required: true
//                 },
//                 certification_name: {
//                     required: true,
//                     maxlength: 100
//                 },
//                 certification_number: {
//                     required: true,
//                     maxlength: 100
//                 },
//                 certification_date_start: {
//                     required: true,
//                 },
//                 certification_date_expired: {
//                     required: true,
//                 }
//             },
//             submitHandler: function(form) {
//                 $.ajax({
//                     url: form.action,
//                     type: form.method,
//                     data: $(form).serialize(),
//                     success: function(response) {
//                         if (response.status) {
//                             Swal.fire({
//                                 icon: 'success',
//                                 title: 'Berhasil',
//                                 text: response.message
//                             });
//                         } else {
//                             $('.error-text').text('');
//                             $.each(response.msgField, function(prefix, val) {
//                                 $('#error-' + prefix).text(val[0]);
//                             });
//                             Swal.fire({
//                                 icon: 'error',
//                                 title: 'Terjadi Kesalahan',
//                                 text: response.message
//                             });
//                         }
//                     }
//                 });
//                 return false;
//             },
//             errorElement: 'span',
//             errorPlacement: function(error, element) {
//                 error.addClass('invalid-feedback');
//                 element.closest('.form-group').append(error);
//             },
//             highlight: function(element, errorClass, validClass) {
//                 $(element).addClass('is-invalid');
//             },
//             unhighlight: function(element, errorClass, validClass) {
//                 $(element).removeClass('is-invalid');
//             }
//         });
//     });

document.addEventListener('DOMContentLoaded', function() {
    const uploadBox = document.querySelector('.upload-box');
    const fileInput = document.getElementById('file-upload');
    const tagsContainer = document.querySelector('.tags-list');
    const tagInput = document.querySelector('.tag-input');
    const tagsCount = document.querySelector('.tags-count');
    const removeAllBtn = document.querySelector('.remove-all-btn');
    const maxTags = 10;
    let tags = [];

    // Fungsi untuk memperbarui tampilan tags
    function updateTags() {
        tagsContainer.innerHTML = '';
        tags.forEach((tag, index) => {
            tagsContainer.innerHTML += `
                <li class="tag-item">
                    <span>${tag}</span>
                    <button type="button" class="remove-tag-btn" onclick="removeTag(${index})">×</button>
                </li>
            `;
        });
        tagsCount.textContent = maxTags - tags.length;
        
        // Sembunyikan input jika sudah mencapai batas maksimal
        tagInput.style.display = tags.length >= maxTags ? 'none' : 'block';
    }

    // Fungsi untuk menambah tag
    function addTag(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            const tag = e.target.value.trim();
            if (tag && !tags.includes(tag) && tags.length < maxTags) {
                tags.push(tag);
                updateTags();
            }
            e.target.value = '';
        }
    }

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

    // Fungsi untuk menghapus tag
    window.removeTag = function(index) {
        tags.splice(index, 1);
        updateTags();
    }

    // Event listener untuk input
    tagInput.addEventListener('keydown', addTag);

    // Event listener untuk tombol hapus semua
    removeAllBtn.addEventListener('click', function() {
        tags = [];
        updateTags();
    });

    // Event listener untuk form submission
    document.getElementById('form-input').addEventListener('submit', function(e) {
        // Tambahkan hidden input untuk menyimpan tags
        const tagsInput = document.createElement('input');
        tagsInput.type = 'hidden';
        tagsInput.name = 'bidang_minat';
        tagsInput.value = JSON.stringify(tags);
        this.appendChild(tagsInput);
    });
});
</script>
@endpush
