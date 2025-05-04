<?php

use Core\Env;
?>

<!-- <style>
    input[type=text]:focus {
        width: 100%;
    }

    /* table {
        table-layout: fixed;
    } */

    table th {
        color: black;
        /* text-align: center; */
        font-size: 10px;
    }

    table td {
        overflow: hidden;
        font-size: 10px;
    }

    .label {
        color: black;
        font-weight: bold;
        font-size: 10px;
    }

    .rightJustified {
        text-align: right;
    }

    .total {
        font-weight: bold;
        color: blue;
    }

    .form-control {
        font-size: inherit;
        font-weight: 400;
    }

    .bodycontainer {
        /* width: 1000px; */
        max-height: 500px;
        margin: 0;
        overflow-y: auto;
    }

    /* #datatable td {
        padding: 2px !important;
        vertical-align: middle;
    } */

    .table-scrollable {
        margin: 0;
        padding: 0;
    }

    .modal-bodys {
        max-height: 250px;
        overflow-y: auto;
    }

    .select2-dropdown {
        width: 500px !important;
    }

    .checkbox_container {
        width: 25px;
        height: 25px;
    }

    td input[type="checkbox"] {
        float: left;
        margin: 0 auto;
        width: 100%;
    }

    .form-control {
        font-size: inherit;
        font-weight: bolder;
        /* text-transform: uppercase; */
    }

    .text-input {
        font-size: 10px;
        font-weight: bolder;
        color: black;
        /* text-transform: uppercase; */
    }

    #modal_bonbahan tbody td {
        font-size: inherit;
        padding: 5;
    }

    .alert-container {
        background-color: Antiquewhite;
        color: black;
        font-weight: bolder;
    }

    .hr-footer {
        border: 2px solid black;
        border-radius: 2px;
        margin: 25px;
    }

    .input-hidden {
        display: none;
    }

    /* SWEETALERT */
    .colored-toast.swal2-icon-success {
        background-color: #4e73df !important;
    }

    .colored-toast.swal2-icon-info {
        background-color: #1ec88b !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #e75042 !important;
    }

    .colored-toast .swal2-title {
        color: white;
    }

    .colored-toast .swal2-close {
        color: white;
    }

    .colored-toast .swal2-html-container {
        color: white;
    }

    .width-select {
        width: 100px;
    }

    .rincian-detail {
        background-color: Antiquewhite;
        color: black;
        text-align: center;
    }

    /* BATAS SWEETALERT */
</style> -->

<form id="form" method="post">
    <div class="card m-3">
        <div class="card-header">
            Sales Order
        </div>
        <div class="card-body">

            <div class="col-md-12">

                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="customer_name">Nama Customer</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control text-input" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="customer_code">Kode Customer</label>
                        <input type="text" name="customer_code" id="customer_code" class="form-control text-input" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="customer_address">Alamat Customer</label>
                        <textarea name="customer_address" id="customer_address" class="form-control text-input" required></textarea>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="production_code">Kode Produksi</label>
                        <input type="text" name="production_code" id="production_code" class="form-control text-input" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="order_number">Nomor Order</label>
                        <input type="text" name="order_number" id="order_number" class="form-control text-input" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="order_date">Tanggal Order</label>
                        <input type="date" name="order_date" id="order_date" class="form-control text-input" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-form-label label" for="payment_terms">Syarat Pembayaran</label>
                        <input type="text" name="payment_terms" id="payment_terms" class="form-control text-input">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label label" for="delivery_plan">Rencana Pengiriman</label>
                        <input type="text" name="delivery_plan" id="delivery_plan" class="form-control text-input">
                    </div>

                    <div class="form-group col-md-3">
                        <label class="col-form-label label" for="manager_production">Manager Produksi</label>
                        <input type="text" name="manager_production" id="manager_production" class="form-control text-input">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="col-form-label label" for="ppic">PPIC</label>
                        <input type="text" name="ppic" id="ppic" class="form-control text-input">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="col-form-label label" for="head_sales">Kabag Penjualan</label>
                        <input type="text" name="head_sales" id="head_sales" class="form-control text-input">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="col-form-label label" for="order_recipient">Penerima Order</label>
                        <input type="text" name="order_recipient" id="order_recipient" class="form-control text-input">
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    <div class="card m-3">
        <div class="card-header">
            Product
        </div>
        <div class="card-body">


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive scrollable">
                        <table id="datatable" class="table table-sm table-scrollable">
                            <thead>
                                <tr>
                                    <th width="100px">Nama Barang</th>
                                    <th width="100px">Warna</th>
                                    <th width="100px">Kadar</th>
                                    <th width="100px">Pcs</th>
                                    <th width="100px">Pairs</th>
                                    <th width="100px">Gram</th>
                                    <th width="100px">Keterangan</th>
                                    <th width="100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input name="product_name[]" id="product_name" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="color[]" id="color" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="karat[]" id="karat" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="pcs[]" id="pcs" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="pairs[]" id="pairs" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="gram[]" id="gram" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="note[]" id="note" type="text"class="form-control text-input" >
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" value="0" name="NO_ID[]" id="NO_ID0" class="form-control"> 
                                        <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick=""> <i class="fa fa-fw fa-trash"></i> </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <button type="button" onclick="tambah()" class="btn btn-sm btn-primary"><i class="fas fa-plus fa-sm md-3"></i> </button>
                    </div>
                </div>

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

            $.ajax({
                url: '<?= Env::get('BASE_URL') ?>/sales-order/store',
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

    var idrow = 1;

    $('body').on('click', '.btn-delete', function() {
        var r = confirm("Yakin dihapus?");
        if (r == true) {
            if (idrow > 1) {
                var val = $(this).parents("tr").remove();
                idrow--;
                nomor();
                // hitung();
            }
        } else {
            hitung();
        }
    });

    function hapus() {
        if (idrow > 1) {
            var x = document.getElementById('datatable').deleteRow(idrow);
            idrow--;
            // nomor();
        }
    }

    function tambah() {

        var x = document.getElementById('datatable').insertRow(idrow + 1);
        var td01 = x.insertCell(0);
        var td02 = x.insertCell(1);
        var td03 = x.insertCell(2);
        var td04 = x.insertCell(3);
        var td05 = x.insertCell(4);
        var td06 = x.insertCell(5);
        var td07 = x.insertCell(6);
        var td08 = x.insertCell(7);

        td08.className = 'text-center';

        td01.innerHTML = "<input name='product_name[]' id=product_name" + idrow + " type='text' class='form-control text-input'>";
        td02.innerHTML = "<input name='color[]' id=color" + idrow + " type='text' class='form-control text-input'>";
        td03.innerHTML = "<input name='karat[]' id=karat" + idrow + " type='text' class='form-control text-input'>";
        td04.innerHTML = "<input name='pcs[]' id=pcs" + idrow + " type='text' class='form-control text-input'>";
        td05.innerHTML = "<input name='pairs[]' id=pairs" + idrow + " type='text' class='form-control text-input'>";
        td06.innerHTML = "<input name='gram[]' id=gram" + idrow + " type='text' class='form-control text-input'>";
        td07.innerHTML = "<input name='note[]' id=note" + idrow + " type='text' class='form-control text-input'>";
        td08.innerHTML = "<input type='hidden' value='0' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'>" +
            " <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

        idrow++;
    }
</script>