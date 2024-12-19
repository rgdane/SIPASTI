@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Data Statistik Dosen dan Tenaga Pendidikan</h3>
        <div class="card-tools">
            {{-- <button onclick="modalAction('{{ url('/statistic/import') }}')" class="btn btn-info">
                <i class="bi bi-file-earmark-excel"></i> Import XLSX</button>
            <a href="{{ url('/statistic/export_excel') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i> Export XLSX</a>
            <a href="{{ url('/statistic/export_pdf') }}" class="btn btn-warning">
                <i class="bi bi-file-earmark-pdf"></i>Export PDF</a> --}}
            {{-- <button onclick="modalAction('{{ url('/statistic/create') }}')" class="btn btn-success"><i class="bi bi-plus"></i> Tambah Data</button> --}}
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-success" style="display: none;">Success message</div>
        <div class="alert alert-danger" style="display: none;">Error message</div>
        <!-- Tambahkan div dengan class table-responsive -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-rounded table-hover table-sm text-center" id="table_statistic" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jumlah Sertifikasi</th>
                        <th>Jumlah Pelatihan</th>
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

    /* #table_statistic th,
    tbody {
        font-size: 0.875rem;
        padding: 0.5rem;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 768px) {
        #table_statistic th,
        #table_statistic td {
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

    var dataStatistic;
    $(document).ready(function() {
        dataStatistic = $('#table_statistic').DataTable({
            serverSide: true,
            responsive: false,
            info: false,
            ajax: {
                url: "{{ url('statistic/list') }}",
                dataType: "json",
                type: "POST",
                data: function(d) {
                    d.statistic_vendor_id = $('#statistic_vendor_id').val();
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "user_fullname", className: "", orderable: false, searchable: true },
                { data: "certification_count", className: "", orderable: true, searchable: false },
                { data: "training_count", className: "", orderable: true, searchable: false },
            ]
        });

        $('#statistic_vendor_id').on('change', function() {
            dataStatistic.ajax.reload();
        });

        //Adjust DataTables on window resize and when sidebar toggle is clicked
        $(window).on('resize', function() {
            dataStatistic.columns.adjust().responsive.recalc();
        });

        $('.sidebar-toggle').on('click', function() {
            setTimeout(function() {
                dataStatistic.columns.adjust().responsive.recalc();
            }, 300); // Timeout to wait for sidebar animation
        });
    });
</script>
@endpush