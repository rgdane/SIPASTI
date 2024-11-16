@extends('layouts.template')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Navigation - Styled as pills instead of tabs -->
    <!-- Minimalist Header Navigation -->
    <div class="header-nav">
        <a href="{{ url('/certification_input') }}" class="nav-link active">Sertifikasi Mandiri</a>
        <a href="{{ url('/certification_upload')}}" class="nav-link">Upload Sertifikasi</a>
    </div>
    <div class="header-border"></div> <br><br>

    <!-- Form tanpa card, langsung di container -->
    <div class="mt-2">        
        <form action="{{ url('/certification_input/store') }}" method="POST" id="form-input" enctype="multipart/form-data">
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
                    <label class="form-label mb-2">Waktu Pelaksanaan</label>
                    <input type="date" class="form-control" id="certification_date" name="certification_date" 
                           value="{{ date('Y-m-d') }}">
                </div>
            
                <!-- Mandiri/Non Mandiri -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Mandiri/Non Mandiri</label>
                    <input type="text" class="form-control" id="certification_type" name="certification_type" 
                           placeholder="Mandiri/Non Mandiri">
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
                    <input type="text" class="form-control" id="organizer" name="organizer" 
                           placeholder="Masukkan lembaga penyelenggara">
                </div>
            
                <!-- Jenis Sertifikasi -->
                <div class="col-md-6 mb-4">
                    <label class="form-label mb-2">Jenis Sertifikasi</label>
                    <input type="text" class="form-control" id="certification_category" name="certification_category" 
                           placeholder="Masukkan jenis sertifikasi">
                </div>
            
                <!-- Mata Kuliah - Full width -->
                <div class="col-12 mb-4">
                    <label class="form-label mb-2">Mata Kuliah</label>
                    <input type="text" class="form-control" id="course" name="course" 
                           placeholder="Masukkan mata kuliah">
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
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
