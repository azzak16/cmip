<?php

use Core\Env;
?>
<form id="form">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
    <div class="form-group">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control"><?= $product['description'] ?></textarea>
    </div>
    <button class="btn btn-success" type="submit">Simpan</button>
</form>

<script>
    $(document).ready(function() {

        $('#form').on('submit', function(e) {
            e.preventDefault();
            var id = $("input[name=id]").val();

            $.ajax({
                url: `<?= Env::get('BASE_URL') ?>/products/update/${id}`,
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