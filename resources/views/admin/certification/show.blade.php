@empty($certification)
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
            <a href="{{ url('/certification') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form id="form-show">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped table-rounded">
                    <div class="alert alert-info">
                        <h5><i class="bi bi-info-circle"></i> Detail Data </h5>
                    </div>
                    <tr>
                        <th class="text-right col-3">Nama Sertifikasi:</th>
                        <td class="col-9">{{ $certification->certification_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nomor Sertifikasi:</th>
                        <td class="col-9">{{ $certification->certification_number }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Berlaku Mulai:</th>
                        <td class="col-9">{{ $certification->certification_date_start }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Berakhir Pada:</th>
                        <td class="col-9">{{ $certification->certification_date_expired }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Periode:</th>
                        <td class="col-9">{{ $certification->certification_period }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Vendor Sertifikasi:</th>
                        <td class="col-9">{{ $certification->certification_vendor_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tipe Sertifikasi:</th>
                        <td class="col-9">{{ $certification->certification_type }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Level Sertifikasi:</th>
                        <td class="col-9">{{ $certification->certification_level }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Dokumen Pendukung:</th>
                        <td class="col-9">
                            {{ basename($certification->certification_file) }}
                            <br>
                            <button type="button" onclick="window.open('{{ url('/certification/' . $certification->certification_id . '/file') }}', '_blank')" class="btn btn-info btn-sm">Lihat Dokumen</button>
                        </td>
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
                                Tidak ada data minat.
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</form>
@endempty

@push('js')
<script>
$(document).ready(function() {
        $("#form-show").validate({
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#modal-master').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataCertification.ajax.reload(); // Reload datatable
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal memproses permintaan.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush