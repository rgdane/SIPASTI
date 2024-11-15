@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Manajemen Sertifikasi</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/certification/import') }}')" class="btn btn-info">
                <i class="bi bi-file-earmark-excel"></i> Import XLSX</button>
            <a href="{{ url('/certification/export_excel') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i> Export XLSX</a>
            <a href="{{ url('/certification/export_pdf') }}" class="btn btn-warning">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            <button onclick="modalAction('{{ url('/certification/create_ajax') }}')" class="btn btn-success">
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
                    <option value="">All Vendors</option>
                    <option value="1">Google</option>
                    <option value="2">IBM</option>
                    <option value="3">The University Of Sydney</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filter_type" class="form-control">
                    <option value="">All Types</option>
                    <option value="1">Sertifikasi Profesi</option>
                </select>
            </div>
            <div class="col-md-3">
                <button id="reset_filters" class="btn btn-secondary w-100">Reset Filters</button>
            </div>
        </div>

        <!-- Certification Cards Container -->
        <div class="row" id="certification_cards">
            <!-- Data from AJAX will populate here -->
        </div>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
<style>
    .certification-card {
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }
    .certification-header {
        font-size: 1rem;
        font-weight: bold;
    }
    .certification-details {
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

    function loadCertifications() {
        $.ajax({
            url: "{{ url('certification/list') }}",
            method: "POST",
            dataType: "json",
            data: {
                search: $('#search').val(),
                certification_vendor_id: $('#filter_vendor').val(),
                certification_type_id: $('#filter_type').val()
            },
            success: function(response) {
                var cardsContainer = $('#certification_cards');
                cardsContainer.empty();

                response.data.forEach(function(certification) {
                    var card = `
                        <div class="col-md-4">
                            <div class="card certification-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="certification-header">${certification.certification_name}</div>
                                            <div class="certification-details">${certification.certification_number}</div>
                                            <div class="certification-details">${certification.vendor.certification_vendor_name}</div>
                                            <div class="certification-details">${certification.course.course_name}</div>
                                        </div>
                                        <div class="dropdown">
                                            <span class="menu-dots" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">⋮</span>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="modalAction('${certification.show_url}')">Detail</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="modalAction('${certification.edit_url}')">Edit</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="modalAction('${certification.delete_url}')">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="certification-details mt-2">
                                        Tanggal: ${certification.certification_date} <br>
                                        Tenggat: ${certification.certification_expired}
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
        loadCertifications();

        // Filter and Search Event Listeners
        $('#search').on('input', function() {
            loadCertifications();
        });
        $('#filter_vendor').on('change', function() {
            loadCertifications();
        });
        $('#filter_type').on('change', function() {
            loadCertifications();
        });
        $('#reset_filters').on('click', function() {
            $('#search').val('');
            $('#filter_vendor').val('');
            $('#filter_type').val('');
            loadCertifications();
        });
    });
</script>
@endpush