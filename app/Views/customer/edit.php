<?php

use Core\Env;
?>


<form id="form" method="post">
    <div class="card m-3">
        <div class="card-header">
            <h5 class="card-title"><?= $data['title'] ?? 'Dashboard'; ?></h5>
        </div>
        <div class="card-body">

            <div class="col-md-12">

                <div class="row">
                    <div class="form-group col-md-6 m-0">
                        <label class="col-form-label label" for="CS_NAMA">Nama Customer</label>
                        <input type="hidden" name="id" value="<?= $data['customer']['NO_ID']; ?>">
                        <input type="text" name="CS_NAMA" id="CS_NAMA" class="form-control text-input" required value="<?= $data['customer']['CS_NAMA']; ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label label" for="CS_KODE">Kode Customer</label>
                        <input type="text" name="CS_KODE" id="CS_KODE" class="form-control text-input" required value="<?= $data['customer']['CS_KODE']; ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label label" for="CS_ALAMAT">Alamat Customer</label>
                        <textarea name="CS_ALAMAT" id="CS_ALAMAT" class="form-control text-input"><?= $data['customer']['CS_ALAMAT']; ?></textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label label" for="NOTES">Keterangan</label>
                        <textarea name="NOTES" id="NOTES" class="form-control text-input"><?= $data['customer']['NOTES']; ?></textarea>
                    </div>
                </div>

                
            </div>

            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary col-md-6 float-right">Simpan</button>
            </div>

        </div>
    </div>


</form>



<script>
    $(document).ready(function() {

        let index = 1;

        $('#form').on('submit', function(e) {
            e.preventDefault();

            var id = $("input[name=id]").val();

            $.ajax({
                url: `<?= Env::get('BASE_URL') ?>/customer/update/${id}`,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                ajaxStart: function() {
                    $('#overlay').fadeIn(100);
                },
                ajaxStop: function() {
                    $('#overlay').fadeOut(100);
                },
                success: function(res) {
                    Toast.fire({
                        icon: "success",
                        title: res.message
                    });
                    window.location.href = res.redirect;

                    // $('#modalForm').modal('hide');
                    // $('#form-product')[0].reset();
                    // table.ajax.reload();
                },
                error: function(xhr) {
                    const err = JSON.parse(xhr.responseText);
                    Toast.fire({
                        icon: "warning",
                        title: err.message
                    });
                }
            });
        });



    });

</script>