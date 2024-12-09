@extends('layouts.template')

@section('content')
<div class="container-fluid px-4">
    <div class="card border-0 shadow">
        <div class="card-header bg-light py-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 text-primary fw-bold">Riwayat Pelatihan</h5>
            <a href="{{ url('/training_input') }}" class="btn btn-success ml-auto text-white">
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
                    {{-- <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="status" id="status" class="form-control" required>
                                <option value="">- Semua -</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Kadaluarsa">Kadaluarsa</option>
                            </select>
                            <small class="form-text text-muted">Status</small>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-hover align-middle" id="training-table"
                    style="width: 100%;">
                    <thead class="text-uppercase text-muted small bg-light">
                        <tr>
                            <th>#</th>
                            <th>Pelatihan</th>
                            <th>Level</th>
                            <th>Periode</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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

        #training-table th,
        #training-table td {
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

function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

var trainingTable;
$(document).ready(function() {
        trainingTable = $('#training-table').DataTable({
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
            url: '{{ url("training_history/list") }}',
            method: 'POST',
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
                data: 'training_name', 
                name: 'training_name' 
            },{ 
                data: 'training_level', 
                name: 'training_level',
                render: function(data) {
                    return data === 'Nasional' ? 'Nasional' : 'Internasional';
                }
            },{ 
                data: 'period_year', 
                name: 'period_year' 
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
        trainingTable.ajax.reload();
    });

    // Adjust DataTables on window resize and when sidebar toggle is clicked
    $(window).on('resize', function() {
        trainingTable.columns.adjust().responsive.recalc();
    });

    // Adjust DataTable columns when sidebar is toggled
    $('.sidebar-toggle').on('click', function() {
        setTimeout(function() {
            trainingTable.columns.adjust().responsive.recalc();
        }, 300); // Adjust delay based on sidebar animation duration
    });
});
</script>
@endpush