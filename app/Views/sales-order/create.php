<?php

use Core\Env;
?>

<style>
    input[type=text]:focus {
        width: 100%;
        /* background-color: gray; */
    }
</style>

<form id="form" method="post">
    <div class="card m-3">
        <div class="card-header">
            Sales Order
        </div>
        <div class="card-body">

            <div class="col-md-12">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label col-form-label-sm" for="customer_name">Nama Customer</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label col-form-label-sm" for="customer_name">Kode Customer</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" required>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="col-form-label col-form-label-sm" for="customer_address">Alamat Customer</label>
                        <textarea name="customer_address" id="customer_address" class="form-control form-control-sm" required></textarea>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label col-form-label-sm" for="production_code">Kode Produksi</label>
                        <input type="text" name="production_code" id="production_code" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="col-form-label col-form-label-sm" for="order_number">Nomor Order</label>
                        <input type="text" name="order_number" id="order_number" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="col-form-label col-form-label-sm" for="order_date">Tanggal Order</label>
                        <input type="date" name="order_date" id="order_date" class="form-control form-control-sm" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label col-form-label-sm" for="payment_terms">Syarat Pembayaran</label>
                        <input type="text" name="payment_terms" id="payment_terms" class="form-control form-control-sm">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label col-form-label-sm" for="delivery_plan">Rencana Pengiriman</label>
                        <input type="text" name="delivery_plan" id="delivery_plan" class="form-control form-control-sm">
                    </div>

                    <div class="form-group col-md-3">
                        <label class="col-form-label col-form-label-sm" for="delivery_plan">Manager Produksi</label>
                        <input type="text" name="delivery_plan" id="delivery_plan" class="form-control form-control-sm">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="col-form-label col-form-label-sm" for="delivery_plan">PPIC</label>
                        <input type="text" name="delivery_plan" id="delivery_plan" class="form-control form-control-sm">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="col-form-label col-form-label-sm" for="delivery_plan">Kabag Penjualan</label>
                        <input type="text" name="delivery_plan" id="delivery_plan" class="form-control form-control-sm">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="col-form-label col-form-label-sm" for="delivery_plan">Penerima Order</label>
                        <input type="text" name="delivery_plan" id="delivery_plan" class="form-control form-control-sm">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Order</button>
            </div>
        </div>
    </div>

    <div class="card m-3">
        <div class="card-header">
            Product
        </div>
        <div class="card-body">
            <button type="button" id="add-item" class="btn btn-secondary mb-3">Tambah Item</button>
            <div id="item-container">
                <div class="item-row p-2 mb-2">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm">Nama Barang</label>
                        <input type="text" name="items[0][product_name]" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm">Warna</label>
                        <input type="text" name="items[0][color]" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm">Kadar</label>
                        <input type="text" name="items[0][karat]" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm">Pcs</label>
                        <input type="number" name="items[0][pcs]" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm">Pairs</label>
                        <input type="number" name="items[0][pairs]" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm">Gram</label>
                        <input type="number" step="0.01" name="items[0][gram]" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm">Keterangan</label>
                        <input type="text" name="items[0][note]" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>



<script>
    $(document).ready(function() {

        let index = 1;
        $('#add-item').click(function(){
            const itemHtml = `
            <div class="item-row border p-2 mb-2">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="items[${index}][product_name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Warna</label>
                    <input type="text" name="items[${index}][color]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Kadar</label>
                    <input type="text" name="items[${index}][karat]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Pcs</label>
                    <input type="number" name="items[${index}][pcs]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Pairs</label>
                    <input type="number" name="items[${index}][pairs]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Gram</label>
                    <input type="number" step="0.01" name="items[${index}][gram]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="items[${index}][note]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger remove-item">Hapus Item</button>
            </div>`;
            $('#item-container').append(itemHtml);
            index++;
        });

        $('#item-container').on('click', '.remove-item', function(){
            $(this).closest('.item-row').remove();
        });

        $('#form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= Env::get('BASE_URL') ?>/products/store',
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