@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Manajemen Pelatihan</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/training/import') }}')" class="btn btn-info">
                <i class="bi bi-file-earmark-excel"></i> Import XLSX</button>
            <a href="{{ url('/training/export_excel') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i> Export XLSX</a>
            <a href="{{ url('/training/export_pdf') }}" class="btn btn-warning">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            <button onclick="modalAction('{{ url('/training/create_ajax') }}')" class="btn btn-success">
                <i class="bi bi-plus"></i> Tambah Data
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-success" style="display: none;">Success message</div>
        <div class="alert alert-danger" style="display: none;">Error message</div>

        <!-- Filter and Search Section -->
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" id="search" class="form-control" placeholder="Search...">
            </div>
            <div class="col-md-3">
                <select id="filter_vendor" class="form-control">
                    <option value="">Semua Vendor</option>
                    <option value="1">Google</option>
                    <option value="2">IBM</option>
                    <option value="3">Microsoft</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filter_type" class="form-control">
                    <option value="">Semua</option>
                    <option value="1">Mandiri</option>
                    <option value="1">Non-Mandiri</option>
                </select>
            </div>
            <div class="col-md-3">
                <button id="reset_filters" class="btn btn-secondary w-100">Reset Filters</button>
            </div>
        </div>

        <!-- Certification Cards Container -->
        <div class="row" id="training_cards">
            <!-- Data from AJAX will populate here -->
        </div>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
<style>
    .training-card {
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }
    .training-header {
        font-size: 1rem;
        font-weight: bold;
    }
    .training-details {
        font-size: 0.875rem;
    }
    .menu-dots {
        cursor: pointer;
        font-size: 1.5rem;
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

    function loadTrainings() {
        $.ajax({
            url: "{{ url('training/list') }}",
            method: "POST",
            dataType: "json",
            data: {
                search: $('#search').val(),
                training_vendor_id: $('#filter_vendor').val(),
                training_type_id: $('#filter_type').val()
            },
            success: function(response) {
                var cardsContainer = $('#training_cards');
                cardsContainer.empty();

                response.data.forEach(function(training) {
                    var card = `
                        <div class="col-md-4">
                            <div class="card training-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="training-header">${training.training_name}</div>
                                            <div class="training-details">${training.vendor.training_vendor_name}</div>
                                            <div class="training-details">${training.course.course_name}</div>
                                            <div class="training-details">${training.type.training_type_name}</div>
                                        </div>
                                        <div class="dropdown">
                                            <span class="menu-dots" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">⋮</span>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="modalAction('${training.show_url}')">Detail</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="modalAction('${training.edit_url}')">Edit</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="modalAction('${training.delete_url}')">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="training-details mt-2">
                                        Tanggal Pelatihan: ${training.training_date} <br>
                                        Lokasi Pelatihan: ${training.training_location} <br>
                                        Biaya Pelatihan: ${training.training_cost} <br>
                                        Kuota Pelatihan: ${training.training_quota}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    cardsContainer.append(card);
                });
            }
        });
    }

    $(document).ready(function() {
        // Initial load
        loadTrainings();

        // Filter and Search Event Listeners
        $('#search').on('input', function() {
            loadTrainings();
        });
        $('#filter_vendor').on('change', function() {
            loadTrainings();
        });
        $('#filter_type').on('change', function() {
            loadTrainings();
        });
        $('#reset_filters').on('click', function() {
            $('#search').val('');
            $('#filter_vendor').val('');
            $('#filter_type').val('');
            loadTrainings();
        });
    });
</script>
@endpush
