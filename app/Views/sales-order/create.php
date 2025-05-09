<?php

use Core\Env;
?>

<form id="form" method="post" enctype="multipart/form-data">
    <div class="card m-3">
        <div class="card-header">
            <h5 class="card-title"><?= $data['title'] ?? 'Dashboard'; ?></h5>
        </div>
        <div class="card-body">

            <div class="col-md-12">

                <div class="row">

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="customer_id">Customer</label>
                        <select name="customer_id" id="customer_id" class="form-control customer-select2" text-input></select>
                    </div>

                    <!-- <div class="form-group col-md-4">
                        <label class="col-form-label label" for="customer_name">Nama Customer</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control text-input" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="customer_code">Kode Customer</label>
                        <input type="text" name="customer_code" id="customer_code" class="form-control text-input" required>
                    </div> -->

                    <!-- <div class="form-group col-md-4">
                        <label class="col-form-label label" for="customer_address">Alamat Customer</label>
                        <textarea name="customer_address" id="customer_address" class="form-control text-input" required></textarea>
                    </div> -->

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="production_code">Kode Produksi</label>
                        <input type="text" name="production_code" id="production_code" class="form-control text-input">
                        <small class="text-muted" style="font-size: 12px;">Jika dikosongi maka kode produksi akan otomatis</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="order_number">Nomor Order</label>
                        <input type="text" name="order_number" id="order_number" class="form-control text-input">
                        <small class="text-muted" style="font-size: 12px;">Jika dikosongi maka nomor so akan otomatis</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="order_date">Tanggal Order</label>
                        <input type="text" name="order_date" id="order_date" class="form-control text-input" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="payment_terms">Syarat Pembayaran</label>
                        <input type="text" name="payment_terms" id="payment_terms" class="form-control text-input">
                    </div>
                    <div class="form-group col-md-4">
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

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="karat_id">Kadar</label>
                        <select name="karat_id" id="karat_id" class="form-control karat-select2" text-input></select>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="col-form-label label" for="status">Status</label>
                        <select name="status" id="status" class="form-control select2" text-input>
                            <option value="DRAFT" selected>Draft</option>
                            <option value="SPK">SPK</option>
                        </select>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    <div class="card m-3">
        <div class="card-header">
            <h5 class="card-titile">Produk</h5>
        </div>
        <div class="card-body">


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive scrollable">
                        <table id="datatable" class="table table-sm table-scrollable">
                            <thead>
                                <tr>
                                    <th width="100px">Nama Barang</th>
                                    <th width="100px">Ukuran @pcs</th>
                                    <th width="100px">Panjang @pcs</th>
                                    <th width="100px">Gram @pcs</th>
                                    <th width="100px">Batu @pcs</th>
                                    <th width="100px">Tok @pcs</th>
                                    <th width="100px">Warna</th>
                                    <!-- <th width="100px">Kadar</th> -->
                                    <th width="100px">Pcs</th>
                                    <th width="100px">Pairs</th>
                                    <th width="100px">Grram</th>
                                    <th width="100px">Keterangan</th>
                                    <th width="100px" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input name="product_desc[]" id="product_desc" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="ukuran_pcs[]" id="ukuran_pcs" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="panjang_pcs[]" id="panjang_pcs" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="gram_pcs[]" id="gram_pcs" type="number" class="form-control text-input" step="any" value="0">
                                    </td>
                                    <td>
                                        <input name="batu_pcs[]" id="batu_pcs" type="text"class="form-control text-input">
                                    </td>
                                    <td>
                                        <input name="tok_pcs[]" id="tok_pcs" type="text"class="form-control text-input" >
                                    </td>
                                    <td>
                                        <input name="color[]" id="color" type="text"class="form-control text-input" >
                                    </td>
                                    <!-- <td>
                                        <input name="karat[]" id="karat" type="text"class="form-control text-input" >
                                    </td> -->
                                    <td>
                                        <input name="pcs[]" id="pcs" type="number" class="form-control text-input" step="any" value="0">
                                    </td>
                                    <td>
                                        <input name="pairs[]" id="pairs" type="number" class="form-control text-input" step="any" value="0">
                                    </td>
                                    <td>
                                        <input name="gram[]" id="gram" type="number" class="form-control text-input" step="any" value="0">
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
            </div>


        </div>
    </div>

    <div class="card m-3">
        <div class="card-header">
            <h5 class="card-title">Foto</h5>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <input type="file" class="filepond" name="images[]" multiple >

                <button type="submit" class="btn btn-primary mt-3 col-md-6 float-right">Simpan</button>
            </div>
        </div>
    </div>

</form>



<script>
    
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateType
    );
    const pond = FilePond.create(document.querySelector('.filepond'), {
        name: 'images[]',
        allowMultiple: true,
        maxFiles: 5, // opsional, batas maksimal
        instantUpload: false, // jika ingin upload saat submit form
        // allowFileEncode: false,
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/gif'],
        labelFileTypeNotAllowed: 'Hanya gambar yang diizinkan.',
        fileValidateTypeLabelExpectedTypes: 'Format yang diizinkan: PNG, JPG, JPEG, WEBP, GIF'
    });

    $(document).ready(function() {        
        $('input[name="order_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $('.select2').select2();

        let index = 1;

        $('#form').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const files = pond.getFiles();
            files.forEach((file, index) => {
                formData.append('images[]', file.file, file.filename);
            });
            // const pond = FilePond.find(document.querySelector('.filepond'));
            // const files = pond.getFiles();
            // files.forEach((file, index) => {
            //     formData.append('images[]', file.file);
            // });

            // console.log(pond.getFiles());


            console.log(formData);
            

            $.ajax({
                url: '<?= Env::get('BASE_URL') ?>/sales-order/store',
                method: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#overlay').removeClass('d-none');
                },
                complete: function() {
                    $('#overlay').addClass('d-none');
                },
                success: function(res) {
                    Toast.fire({
                        icon: "success",
                        title: res.message
                    });
                    window.location.href = res.redirect;
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle error
                    $('#overlay').addClass('d-none');
                    // Display error message or perform other error handling tasks
                    console.error('AJAX error:', textStatus, errorThrown);
                    console.log('Response:', xhr.responseText);
                    const err = JSON.parse(xhr.responseText);
                    
                    Toast.fire({
                        icon: "warning",
                        title: err.message
                    });
                }
            });
        });

        $('.customer-select2').select2({
            ajax: {
                url: '<?= Env::get('BASE_URL') ?>/customer/select',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,  // teks yang diketik user
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.items.map(function(item) {
                            return { id: item.id, text: item.text };
                        }),
                        pagination: {
                            more: data.hasMore
                        }
                    };
                }
            },
            placeholder: 'Pilih customer',
            minimumInputLength: 0
        });


        $('.karat-select2').select2({
            ajax: {
                url: '<?= Env::get('BASE_URL') ?>/karat/salesSelect',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,  // teks yang diketik user
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items.map(function(item) {
                            return { id: item.id, text: item.text };
                        }),
                        pagination: {
                            more: data.hasMore
                        }
                    };
                }
            },
            placeholder: 'Pilih kadar',
            minimumInputLength: 0
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
        // var td08 = x.insertCell(7);
        var td08 = x.insertCell(7);
        var td09 = x.insertCell(8);
        var td10 = x.insertCell(9);
        var td11 = x.insertCell(10);
        var td12 = x.insertCell(11);

        td12.className = 'text-center';

        td01.innerHTML = "<input name='product_desc[]' id=product_desc" + idrow + " type='text' class='form-control text-input'>";
        td02.innerHTML = "<input name='ukuran_pcs[]' id=ukuran_pcs" + idrow + " type='text' class='form-control text-input'>";
        td03.innerHTML = "<input name='panjang_pcs[]' id=panjang_pcs" + idrow + " type='text' class='form-control text-input'>";
        td04.innerHTML = "<input name='gram_pcs[]' id=gram_pcs" + idrow + " type='text' class='form-control text-input' step='any' value='0'>";
        td05.innerHTML = "<input name='batu_pcs[]' id=batu_pcs" + idrow + " type='text' class='form-control text-input'>";
        td06.innerHTML = "<input name='tok_pcs[]' id=tok_pcs" + idrow + " type='text' class='form-control text-input'>";
        td07.innerHTML = "<input name='color[]' id=color" + idrow + " type='text' class='form-control text-input'>";
        // td08.innerHTML = "<input name='karat[]' id=karat" + idrow + " type='text' class='form-control text-input'>";
        td08.innerHTML = "<input name='pcs[]' id=pcs" + idrow + " type='text' class='form-control text-input' step='any' value='0'>";
        td09.innerHTML = "<input name='pairs[]' id=pairs" + idrow + " type='text' class='form-control text-input' step='any' value='0'>";
        td10.innerHTML = "<input name='gram[]' id=gram" + idrow + " type='text' class='form-control text-input' step='any' value='0'>";
        td11.innerHTML = "<input name='note[]' id=note" + idrow + " type='text' class='form-control text-input'>";
        td12.innerHTML = "<input type='hidden' value='0' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control'>" +
            " <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

        idrow++;
    }
</script>