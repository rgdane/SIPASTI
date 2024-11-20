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
<form action="{{ url('/training/' . $training['training_id'] . '/show') }}" method="POST" id="form-show">
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
                        <td class="col-9">{{ $training['training_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Pelatihan:</th>
                        <td class="col-9">{{ $training['training_date'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Lokasi Pelatihan:</th>
                        <td class="col-9">{{ $training['training_location'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Biaya Pelatihan:</th>
                        <td class="col-9">{{ $training['training_cost'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Vendor Pelatihan:</th>
                        <td class="col-9">{{ $training['vendor']['training_vendor_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tipe Pelatihan:</th>
                        <td class="col-9">{{ $training['type']['training_type_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kuota Pelatihan:</th>
                        <td class="col-9">{{ $training['training_quota'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Mata Kuliah:</th>
                        <td class="col-9">{{ $training['course']['course_name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Bidang Minat:</th>
                        <td class="col-9">{{ $training['interest']['interest_name'] }}</td>
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
                            dataTraining.ajax.reload(); // Reload datatable
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