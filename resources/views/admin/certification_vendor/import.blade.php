<form action="{{ url('/certification_vendor/import_excel') }}" method="POST" id="form-import">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Jenis Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('template_vendor_sertifikasi.xlsx') }}" class="btn btn-info btn-sm" download><i
                            class="fa fa-file-excel"></i>Download</a>
                    <small id="error-certification_vendor_id" class="error-text form-text text-danger"></small>
                </div>
                <p>Anda dapat mengimpor data pengguna dengan mengklik tombol di bawah ini.</p>
                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="file_certification_vendor" id="file_certification_vendor" class="form-control" required>
                    <small id="error-file_certification_vendor" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="button" id="btn-import-static" class="btn btn-primary">Import Data Statis</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-import").validate({
            rules: {
                file_certification_vendor: {  // Mengubah dari file_level ke file_certification_vendor
                    required: true,
                    extension: "xlsx"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form); // Mengubah form menjadi FormData untuk menghandle file
                $.ajax({
                    url: form.action, // Mengubah $url ke url
                    type: form.method,
                    data: formData, // Data yang dikirim berupa FormData
                    processData: false, // Setting processData dan contentType ke false untuk menghandle file
                    contentType: false,
                    success: function(response) {
                        if (response.status) { // Jika sukses
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataCertificationVendor.ajax.reload(); // Reload DataTables
                        } else { // Jika terjadi error
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengimpor data.'
                        });
                    }
                });
                return false;
            }
        });

        // Trigger submitHandler dengan mengklik tombol "Import Data Statis"
        $('#btn-import-static').on('click', function() {
            $('#form-import').submit(); // Memicu submit pada form
        });
    });
</script>
