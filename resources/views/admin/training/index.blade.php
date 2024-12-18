@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Manajemen Pelatihan</h3>
        <div class="card-tools">
            {{-- <button onclick="modalAction('{{ url('/training/import') }}')" class="btn btn-info">
                <i class="bi bi-file-earmark-excel"></i> Import XLSX</button>
            <a href="{{ url('/training/export_excel') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i> Export XLSX</a>
            <a href="{{ url('/training/export_pdf') }}" class="btn btn-warning">
                <i class="bi bi-file-earmark-pdf"></i>Export PDF</a> --}}
            <button onclick="modalAction('{{ url('/training/create/true') }}')" class="btn btn-success">
                <i class="bi bi-plus"></i> Tambah Data</button>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-success" style="display: none;">Success message</div>
        <div class="alert alert-danger" style="display: none;">Error message</div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" name="training_level" id="training_level" required>
                            <option value="">- Semua -</option>
                            <option value="0">Nasional</option>
                            <option value="1">Internasional</option>
                        </select>
                        <small class="form-text text-muted">Level Pelatihan</small>
                    </div>
                    <div class="col-3">
                        <select class="form-control" name="training_status" id="training_status" required>
                            <option value="">- Semua -</option>
                            <option value="1">Pengajuan</option>
                            <option value="2">Ditolak</option>
                            <option value="3">Disetujui</option>
                            <option value="4">Selesai</option>
                        </select>
                        <small class="form-text text-muted">Status Pelatihan</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tambahkan div dengan class table-responsive -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-rounded table-hover table-sm text-center"
                id="table_training" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelatihan</th>
                        <th>Tahun Periode</th>
                        <th>Tanggal</th>
                        <th>Level Pelatihan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data from AJAX will populate here -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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

    /* #table_training th,
    tbody {
        font-size: 0.875rem;
        padding: 0.5rem;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 768px) {
        #table_training th,
        #table_training td {
            font-size: 0.75rem;
            padding: 0.3rem;
        }
    } */
</style>
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataTraining;
    $(document).ready(function() {
        dataTraining = $('#table_training').DataTable({
            serverSide: true,
            responsive: false,
            info: false,
            ajax: {
            url: "{{ url('training/list') }}",
            dataType: "json",
            type: "POST",
            data: function(d) {
                d.training_vendor_id = $('#training_vendor_id').val();
                d.training_level = $('#training_level').val(); // Tambahkan baris ini
                d.training_status = $('#training_status').val(); // Tambahkan baris ini
            }
        },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "training_name", className: "", orderable: true, searchable: true },
                { data: "period_year", className: "", orderable: true, searchable: true },
                { data: "training_date", className: "", orderable: true, searchable: true },
                { data: "training_level", className: "", orderable: false, searchable: false },
                { data: "training_status", className: "", orderable: false, searchable: false },
                { data: "aksi", className: "", orderable: false, searchable: false }
            ]
        });

        $('#training_vendor_id').on('change', function() {
            dataTraining.ajax.reload();
        });

        $('#training_level').on('change', function() {
            dataTraining.ajax.reload();
        });
        
        $('#training_status').on('change', function() {
            dataTraining.ajax.reload();
        });

        // Adjust DataTables on window resize and when sidebar toggle is clicked
        // $(window).on('resize', function() {
        //     dataTraining.columns.adjust().responsive.recalc();
        // });

        // $('.sidebar-toggle').on('click', function() {
        //     setTimeout(function() {
        //         dataTraining.columns.adjust().responsive.recalc();
        //     }, 300); // Timeout to wait for sidebar animation
        // });
    });
</script>
@endpush