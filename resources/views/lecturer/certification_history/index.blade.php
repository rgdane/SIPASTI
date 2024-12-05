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
            @if($certifications->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('image/folder.png') }}" alt="Belum Ada Sertifikasi" class="mb-3" style="max-width: 200px; opacity: 0.8;">
                    <h5 class="text-muted">Belum Ada Sertifikasi</h5>
                    <p class="text-muted">Anda belum menambahkan sertifikasi apapun. Yuk, tambahkan sertifikasimu!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-borderless align-middle" id="certification-table">
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
                        <tbody>
                            @foreach($certifications as $key => $certification)
                                <tr class="border-bottom">
                                    <td class="fw-bold">{{ $key + 1 }}</td>
                                    <td>{{ $certification->certification_name }}</td>
                                    <td>{{ $certification->certification_type == 0 ? 'Nasional' : 'Internasional' }}</td>
                                    <td>{{ $certification->certification_level == 0 ? 'Profesi' : 'Keahlian' }}</td>
                                    <td>{{ $certification->period->period_year }}</td>
                                    <td>
                                        @php
                                            $now = now();
                                            $expired = \Carbon\Carbon::parse($certification->certification_date_expired);
                                        @endphp
                                        @if($now > $expired)
                                            <span class="badge bg-danger-light text-danger">Kadaluarsa</span>
                                        @else
                                            <span class="badge bg-success-light text-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ url('/certification_history/show/' . $certification->certification_id) }}" 
                                           class="btn btn-sm btn-light border me-2" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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

// $(document).ready(function() {
//     // DataTable initialization
//     $('#certification-table').DataTable({
//         responsive: true,
//         language: {
//             search: "Cari:",
//             lengthMenu: "Tampilkan _MENU_ data",
//             info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
//             infoEmpty: "Tidak ada data yang ditampilkan",
//             infoFiltered: "(disaring dari _MAX_ total data)",
//             zeroRecords: "Tidak ada data yang cocok",
//             paginate: {
//                 first: "Pertama",
//                 last: "Terakhir",
//                 next: "Selanjutnya",
//                 previous: "Sebelumnya"
//             }
//         }
//     });
// });
</script>
@endpush
