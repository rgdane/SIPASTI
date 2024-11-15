@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        {{-- <h3 class="card-title">Manajemen Jenis Pengguna</h3> --}}
        {{-- <div class="card-tools">
            <button onclick="modalAction('{{ url('/user_type/import') }}')" class="btn btn-info">
                <i class="bi bi-file-earmark-excel"></i> Import XLSX</button>
            <a href="{{ url('/user_type/export_excel') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i> Export XLSX</a>
            <a href="{{ url('/user_type/export_pdf') }}" class="btn btn-warning">
                <i class="bi bi-file-earmark-pdf"></i>Export PDF</a>
            <button onclick="modalAction('{{ url('/user_type/create') }}')" class="btn btn-success"><i class="bi bi-person-plus"></i> Tambah Data</button>
        </div> --}}
    </div>
    <div class="card-body">
        <div class="alert alert-success" style="display: none;">Success message</div>
        <div class="alert alert-danger" style="display: none;">Error message</div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-rounded table-hover table-sm text-center" id="table_user_type">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Jenis Pengguna</th>
                        <th>Nama Jenis Pengguna</th>
                        {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
            </table>
        </div>
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

    /* CSS untuk memperkecil teks header tabel */
    #table_user_type th {
        font-size: 0.875rem; /* Sesuaikan ukuran teks */
        padding: 0.5rem;
    }

    /* Responsivitas tabel di layar kecil */
    @media (max-width: 768px) {
        #table_user_type th, #table_user_type td {
            font-size: 0.75rem;
            padding: 0.3rem;
        }
    }
</style>
@endpush

@push('js')
<script>
    function modalAction(url = ''){
        $('#myModal').load(url, function(){
            $('#myModal').modal('show');
        });
    }
    
    var dataUserType;
    $(document).ready(function(){
        dataUserType = $('#table_user_type').DataTable({
            serverSide: true,
            paging: false, // Disable pagination
            lengthChange: false, // Disable the "Show entries" dropdown
            info: false, // Disable the "Showing X of Y entries" info
            ajax:{
                "url": "{{ url('user_type/list') }}",
                "dataType": "json",
                "type": "POST"
            },
            columns:[
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },{
                    data: "user_type_code",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "user_type_name",
                    className: "",
                    orderable: true,
                    searchable: true
                }
                // ,{
                //     data: "aksi",
                //     className: "",
                //     orderable: false,
                //     searchable: false
                // }
            ]
        });
    });
</script>
@endpush
