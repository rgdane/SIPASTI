@extends('layouts.template')

@section('content')
<div class="container-fluid px-4">
    <div class="card border-0 shadow">
        <div class="card-header bg-light py-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 text-primary fw-bold">Riwayat Sertifikasi</h5>
            <a href="{{ url('/certification_input') }}" class="btn btn-success ml-auto text-white">
                <i class="bi bi-plus"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="status" id="status" class="form-control" required>
                                <option value="">- Semua -</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Kadaluarsa">Kadaluarsa</option>
                            </select>
                            <small class="form-text text-muted">Status</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-hover align-middle" id="certification-table"
                    style="width: 100%;">
                    <thead class="text-uppercase text-muted small bg-light">
                        <tr>
                            <th>#</th>
                            <th>Sertifikasi</th>
                            <th>Jenis</th>
                            <th>Level</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .table-borderless th,
    .table-borderless td {
        vertical-align: middle;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 768px) {

        #certification-table th,
        #certification-table td {
            font-size: 0.75rem;
            padding: 0.3rem;
        }
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5em 0.75em;
        border-radius: 12px;
    }

    .bg-danger-light {
        background-color: rgba(255, 0, 0, 0.1);
    }

    .bg-success-light {
        background-color: rgba(0, 128, 0, 0.1);
    }

    .btn-light {
        background-color: #f9f9f9;
    }

    .btn-light:hover {
        background-color: #f1f1f1;
    }

    .table thead th {
        font-size: 0.85rem;
        letter-spacing: 0.05em;
    }
</style>
@endpush

@push('js')
<script>
var certificationTable;
$(document).ready(function() {
        certificationTable = $('#certification-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthChange: true,
        info: false,
        language: {
            processing: `
                <div class="d-flex flex-column align-items-center">
                    <div class="spinner-grow text-primary mb-2" role="status" style="width: 3rem; height: 3rem;"></div>
                    <div class="text-muted">Memuat..</div>
                </div>
            `
        },
        ajax: {
            url: '{{ url("certification_history/list") }}',
            method: 'GET',
            data: function (d) {
                d.status = $('#status').val();   
            }
        },
        columns: [
            { 
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false 
            },{ 
                data: 'certification_name', 
                name: 'certification_name' 
            },{ 
                data: 'certification_level', 
                name: 'certification_level',
                render: function(data) {
                    return data === 'Nasional' ? 'Nasional' : 'Internasional';
                }
            },{ 
                data: 'certification_type', 
                name: 'certification_type',
                render: function(data) {
                    return data === 'Profesi' ? 'Profesi' : 'Keahlian';
                }
            },{ 
                data: 'period_year', 
                name: 'period_year' 
            },{ 
                data: 'status', 
                name: 'status',
                render: function(data) {
                    // Parse the JSON data for status
                    var statusData = JSON.parse(data);
                    return '<span class="badge ' + statusData.class + '">' + statusData.text + '</span>';
                }
            },{ 
                data: 'aksi', 
                name: 'aksi', 
                orderable: false, 
                searchable: false,
                className: 'text-end'
            }
        ],
    });

    $('#status').on('change', function() {
        certificationTable.ajax.reload();
    });

    // Adjust DataTables on window resize and when sidebar toggle is clicked
    $(window).on('resize', function() {
        certificationTable.columns.adjust().responsive.recalc();
    });

    // Adjust DataTable columns when sidebar is toggled
    $('.sidebar-toggle').on('click', function() {
        setTimeout(function() {
            certificationTable.columns.adjust().responsive.recalc();
        }, 300); // Adjust delay based on sidebar animation duration
    });
});
</script>
@endpush