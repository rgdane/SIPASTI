@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Manajemen Tahun Periode</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/period/create') }}')" class="btn btn-success"><i
                    class="bi bi-plus-circle"></i> Tambah Data</button>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-success" style="display: none;">Success message</div>
        <div class="alert alert-danger" style="display: none;">Error message</div>
        <table class="table table-bordered table-striped table-rounded table-hover table-sm text-center"
            id="table_period" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data from AJAX will populate here -->
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>Show
                <select class="custom-select custom-select-sm form-control form-control-sm w-auto">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select> entries
            </div>
            <div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
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

    #table_period th, tbody {
        font-size: 0.875rem;
        padding: 0.5rem;
    }

    @media (max-width: 768px) {
        #table_period th,
        #table_period td {
            font-size: 0.75rem;
            padding: 0.3rem;
        }
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

    var dataPeriod;
    $(document).ready(function() {
        dataPeriod = $('#table_period').DataTable({
            serverSide: true,
            responsive: true,
            paging: false, // Disable pagination if you want to use custom pagination
            lengthChange: false,
            info: false,
            ajax: {
                url: "{{ url('period/list') }}",
                dataType: "json",
                type: "POST",
                data: function(d) {
                    d.period_id = $('#period_id').val();
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "period_year", className: "", orderable: true, searchable: true },
                { data: 'aksi', className: "", orderable: false, searchable: false }
            ]
        });

        $('#period_id').on('change', function() {
            dataPeriod.ajax.reload();
        });

        // Adjust DataTables on window resize and when sidebar toggle is clicked
        $(window).on('resize', function() {
            dataPeriod.columns.adjust().responsive.recalc();
        });

        $('.sidebar-toggle').on('click', function() {
            setTimeout(function() {
                dataPeriod.columns.adjust().responsive.recalc();
            }, 300); // Timeout to wait for sidebar animation
        });
    });
</script>
@endpush
