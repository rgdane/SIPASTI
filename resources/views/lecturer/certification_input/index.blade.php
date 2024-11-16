@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Input Sertifikasi</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-success" style="display: none;">Success message</div>
        <div class="alert alert-danger" style="display: none;">Error message</div>
        
        <!-- Form Input -->
        <form action="{{ url('/certification_input/'.$userId.'/store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <!-- Jenis Sertifikasi -->
                <div class="form-group">
                    <label for="certificationType">Jenis Sertifikasi</label>
                    <select class="form-control" id="certification_type" name="certification_type">
                        <option value="">-- Pilih Jenis Sertifikasi --</option>
                        <!-- Opsi jenis sertifikasi dari backend -->
                        <option value="0">Profesi</option>
                        <option value="1">Keahlian</option>
                    </select>
                </div>
                
                <!-- Level Sertifikasi -->
                <div class="form-group">
                    <label for="certificationLevel">Level Sertifikasi</label>
                    <select class="form-control" id="certification_level" name="certification_level">
                        <option value="">-- Pilih Level Sertifikasi --</option>
                        <!-- Opsi level sertifikasi dari backend -->
                        <option value="0">Nasional</option>
                        <option value="1">Internasional</option>
                    </select>
                </div>

                <!-- Vendor Sertifikasi -->
                <div class="form-group">
                    <label for="certificationVendor">Vendor Sertifikasi</label>
                    <select class="form-control" id="certification_vendor_id" name="certification_vendor_id">
                        <option value="">-- Pilih Vendor --</option>
                        @foreach($certification_vendor as $l) 
                            <option value="{{ $l->certification_vendor_id }}">{{ $l->certification_vendor_name }}</option> 
                        @endforeach
                    </select>
                </div>
                
                <!-- Nomor Sertifikasi -->
                <div class="form-group">
                    <label for="certificationNumber">Nomor Sertifikasi</label>
                    <input type="text" class="form-control" id="certification_number" name="certification_number" placeholder="Masukkan nomor sertifikasi">
                </div>

                <!-- Nama Sertifikasi -->
                <div class="form-group">
                    <label for="certificationName">Nama Sertifikasi</label>
                    <input type="text" class="form-control" id="certification_name" name="certification_name" placeholder="Masukkan nama sertifikasi">
                </div>

                <!-- Tanggal Mulai Berlaku -->
                <div class="form-group">
                    <label class="font-weight-bold">
                        Tanggal Mulai Berlaku
                    </label>
                    <input value="" type="date" name="certification_date_start" id="certification_date_start" class="form-control border-primary" required>
                    <small id="error-certification_date_start" class="error-text form-text text-danger"></small>
                </div>

                <!-- Tanggal Akhir Berlaku -->
                <div class="form-group">
                    <label class="font-weight-bold">
                        Tanggal Akhir Berlaku
                    </label>
                    <input value="" type="date" name="certification_date_expired" id="certification_date_expired" class="form-control border-primary" required>
                    <small id="error-certification_date_expired" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="certification_file" id="certification_file" class="form-control" required>
                    <small id="error-certification_file" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
@endsection

@push('css')
<style>
    .table-rounded {
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #table_certification th, tbody {
        font-size: 0.875rem;
        padding: 0.5rem;
    }

    @media (max-width: 768px) {
        #table_certification th,
        #table_certification td {
            font-size: 0.75rem;
            padding: 0.3rem;
        }
    }
</style>
@endpush

@push('js')
<script>
    $(function() {
        // Initialize date pickers
        $('#startDatePicker').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        $('#endDatePicker').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false // Ensure end date is after start date
        });

        // Prevent end date before start date
        $('#startDatePicker').on('change.datetimepicker', function(e) {
            $('#endDatePicker').datetimepicker('minDate', e.date);
        });
        $('#endDatePicker').on('change.datetimepicker', function(e) {
            $('#startDatePicker').datetimepicker('maxDate', e.date);
        });
    });
</script>
@endpush
