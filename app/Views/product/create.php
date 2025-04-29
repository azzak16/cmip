<?php

use Core\Env;
?>
<form id="form">
    <div class="form-group">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button class="btn btn-success" type="submit">Simpan</button>
</form>

<script>
    $(document).ready(function() {

        $('#form').on('submit', function(e) {
            e.preventDefault();
// alert('asd');
            $.ajax({
                url: 'http://localhost/cmip2/products/store',
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    toastr.success(res.message);
                    $('#modalForm').modal('hide');
                    $('#form-product')[0].reset();
                    table.ajax.reload();
                },
                error: function(xhr) {
                    const err = JSON.parse(xhr.responseText);
                    toastr.error(err.message);
                }
            });
        });
    });

</script>