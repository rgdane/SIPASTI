@empty($training)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="bi bi-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('/training') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form id="form-show">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped table-rounded">
                    <div class="alert alert-info">
                        <h5><i class="bi bi-info-circle"></i> Detail Data </h5>
                    </div>
                    <tr>
                        <th class="text-right col-3">Nama Pelatihan:</th>
                        <td class="col-9">{{ $training->training_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Level Pelatihan:</th>
                        <td class="col-9">{{ $training->training_level }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Vendor Pelatihan:</th>
                        <td class="col-9">{{ $training->training_vendor_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Periode:</th>
                        <td class="col-9">{{ $training->period_year }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Pelatihan:</th>
                        <td class="col-9">{{ $training->training_date }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Durasi Pelatihan:</th>
                        <td class="col-9">{{ $training->training_hours }} jam</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Lokasi Pelatihan:</th>
                        <td class="col-9">{{ $training->training_location }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Biaya Pelatihan:</th>
                        <td class="col-9">Rp {{ number_format($training->training_cost, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kuota Pelatihan:</th>
                        <td class="col-9">{{ $training->training_quota }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Bidang Minat:</th>
                        <td class="col-9">
                            @php $interestCount = is_countable($interest) ? count($interest) : 0; @endphp

                            @if (is_iterable($interest))
                            @foreach ($interest as $index => $item)
                                {{ $item->interest_name }}@if ($index < count($interest) - 1), @endif
                            @endforeach
                            @else
                                Tidak ada data minat.
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Mata Kuliah:</th>
                        <td class="col-9">
                            @php $courseCount = is_countable($course) ? count($course) : 0; @endphp

                            @if (is_iterable($course))
                            @foreach ($course as $index => $item)
                                {{ $item->course_name }}@if ($index < count($course) - 1), @endif
                            @endforeach
                            @else
                                Tidak ada data mata kuliah.
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Status Pelatihan:</th>
                        <td class="col-9">{{ $training->training_status }}</td>
                    </tr>
                </table>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-rounded table-hover table-sm text-center"
                        id="table_user" style="width: 100%;">
                        <div class="alert alert-info">
                            <h5> Peserta Pelatihan </h5>
                        </div>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data from AJAX will populate here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</form>
@endempty

<script>
    $(document).ready(function() {
        $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            info: false,
            ajax: {
                url: "{{ url('training/'.$training->training_id.'/show_member') }}",
                dataType: "json",
                type: "POST",
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "user_fullname", className: "", orderable: true, searchable: true },
            ]
        });
    });
</script>
