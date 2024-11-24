@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Manajemen Pengguna</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info">
                <i class="bi bi-file-earmark-excel"></i> Import XLSX</button>
            <a href="{{ url('/user/export_excel') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i> Export XLSX</a>
            <a href="{{ url('/user/export_pdf') }}" class="btn btn-warning">
                <i class="bi bi-file-earmark-pdf"></i>Export PDF</a>
            <button onclick="modalAction('{{ url('/user/create') }}')" class="btn btn-success"><i class="bi bi-person-plus"></i> Tambah Data</button>
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
                        <select class="form-control" name="user_type_id" id="user_type_id" required>
                            <option value="">- Semua -</option>
                            @foreach ($user_type as $item )
                            <option value="{{$item->user_type_id}}">{{ $item->user_type_name}}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Jenis Pengguna</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-rounded table-hover table-sm text-center" id="table_user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Pengguna</th>
                        <th>Username</th>
                        <th>Nama Pengguna</th>
                        <th>Aksi</th>
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
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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
</style>
@endpush
@push('js')
<script>
    function modalAction(url = ''){
        $('#myModal').load(url, function(){
            $('#myModal').modal('show');
        });
    }
    
    var dataUser;
    $(document).ready(function(){
        dataUser = $('#table_user').DataTable({
            serverSide: true,
            paging: false, // Disable pagination
            lengthChange: false, // Disable the "Show entries" dropdown
            info: false, // Disable the "Showing X of Y entries" info
            ajax:{
                "url": "{{ url('user/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d){
                    d.user_type_id = $('#user_type_id').val();
                }
            },
            columns:[
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },{
                    data: "user_type.user_type_name",
                    className: "",
                    orderable: false,
                    searchable: false
                },{
                    data: "username",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "user_fullname",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#user_type_id').on('change', function(){
            dataUser.ajax.reload();
        });
    });
</script>
@endpush