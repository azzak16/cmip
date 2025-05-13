<?php

use Core\Env;
?>
<div class="row">
    <div class="col-md-12">
        <form id="form" method="post" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?= $data['title'] ?? 'Dashboard'; ?></h5>
                </div>
                <div class="card-body">
        
                    <div class="col-md-12">
        
                        <div class="row">
        
                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="customer_id">Customer</label>
                                <input type="hidden" name="id" value="<?= $data['sales_orders'][0]['id'] ?>">
                                <select name="customer_id" id="customer_id" class="form-control form-control-sm customer-select2" >
                                    <option value="<?= $data['sales_orders'][0]['customer_id'] ?>"><?= $data['sales_orders'][0]['CS_NAMA'] ?></option>
                                </select>
                            </div>
        
                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="production_code">Kode Produksi</label>
                                <input type="text" name="production_code" id="production_code" class="form-control form-control-sm " value="<?= $data['sales_orders'][0]['production_code'] ?>">
                                <small class="text-muted" style="font-size: 12px;">Jika dikosongi maka kode produksi akan otomatis</small>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="order_number">Nomor Order</label>
                                <input type="text" name="order_number" id="order_number" class="form-control form-control-sm " value="<?= $data['sales_orders'][0]['order_number'] ?>">
                                <small class="text-muted" style="font-size: 12px;">Jika dikosongi maka nomor so akan otomatis</small>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="order_date">Tanggal Order</label>
                                <input type="text" name="order_date" id="order_date" class="form-control form-control-sm " required value="<?= $data['sales_orders'][0]['order_date'] ?>">
                            </div>
        
                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="payment_terms">Syarat Pembayaran</label>
                                <input type="text" name="payment_terms" id="payment_terms" class="form-control form-control-sm " value="<?= $data['sales_orders'][0]['payment_terms'] ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="delivery_plan">Rencana Pengiriman</label>
                                <input type="text" name="delivery_plan" id="delivery_plan" class="form-control form-control-sm " value="<?= $data['sales_orders'][0]['delivery_plan'] ?>">
                            </div>
        
                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="manager_production">Manager Produksi</label>
                                <input type="text" name="manager_production" id="manager_production" class="form-control form-control-sm " value="<?= $data['sales_orders'][0]['manager_production'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="ppic">PPIC</label>
                                <input type="text" name="ppic" id="ppic" class="form-control form-control-sm " value="<?= $data['sales_orders'][0]['ppic'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="head_sales">Kabag Penjualan</label>
                                <input type="text" name="head_sales" id="head_sales" class="form-control form-control-sm " value="<?= $data['sales_orders'][0]['head_sales'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="order_recipient">Penerima Order</label>
                                <input type="text" name="order_recipient" id="order_recipient" class="form-control form-control-sm " value="<?= $data['sales_orders'][0]['order_recipient'] ?>">
                            </div>
        
                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="karat_id">Kadar</label>
                                <select name="karat_id" id="karat_id" class="form-control form-control-sm karat-select2" >
                                    <option value="<?= $data['sales_orders'][0]['karat'] ?>"><?= $data['sales_orders'][0]['karat'] ?></option>
                                </select>
                            </div>
        
                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="status">Status</label>
                                <select name="status" id="status" class="form-control form-control-sm select2" >
                                    <option value="DRAFT" <?= ($data['sales_orders'][0]['status']=='DRAFT')?'selected':'' ?>>Draft</option>
                                    <option value="SPK" <?= ($data['sales_orders'][0]['status']=='SPK')?'selected':'' ?>>SPK</option>
                                </select>
                            </div>
                        </div>
        
                        
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Produk</h5>
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
                                        <?php foreach ($data['sales_order_items'] as $key => $value) :?>
                                        <tr>
                                            <td>
                                                <input name="item_id[]" id="item_id" type="hidden"class="form-control form-control-sm " value="<?= $value['id'] ?>">
                                                <input name="product_desc[]" id="product_desc" type="text"class="form-control form-control-sm " value="<?= $value['product_desc'] ?>">
                                            </td>
                                            <td>
                                                <input name="ukuran_pcs[]" id="ukuran_pcs" type="text"class="form-control form-control-sm " value="<?= $value['ukuran_pcs'] ?>">
                                            </td>
                                            <td>
                                                <input name="panjang_pcs[]" id="panjang_pcs" type="text"class="form-control form-control-sm " value="<?= $value['panjang_pcs'] ?>">
                                            </td>
                                            <td>
                                                <input name="gram_pcs[]" id="gram_pcs" type="number" class="form-control form-control-sm " step="any" value="<?= $value['gram_pcs'] ?>">
                                            </td>
                                            <td>
                                                <input name="batu_pcs[]" id="batu_pcs" type="text"class="form-control form-control-sm " value="<?= $value['batu_pcs'] ?>">
                                            </td>
                                            <td>
                                                <input name="tok_pcs[]" id="tok_pcs" type="text"class="form-control form-control-sm " value="<?= $value['tok_pcs'] ?>">
                                            </td>
                                            <td>
                                                <input name="color[]" id="color" type="text"class="form-control form-control-sm " value="<?= $value['color'] ?>">
                                            </td>
                                            <!-- <td>
                                                <input name="karat[]" id="karat" type="text"class="form-control form-control-sm " >
                                            </td> -->
                                            <td>
                                                <input name="pcs[]" id="pcs" type="number" class="form-control form-control-sm " step="any" value="<?= $value['pcs'] ?>">
                                            </td>
                                            <td>
                                                <input name="pairs[]" id="pairs" type="number" class="form-control form-control-sm " step="any" value="<?= $value['pairs'] ?>">
                                            </td>
                                            <td>
                                                <input name="gram[]" id="gram" type="number" class="form-control form-control-sm " step="any" value="<?= $value['gram'] ?>">
                                            </td>
                                            <td>
                                                <input name="note[]" id="note" type="text"class="form-control form-control-sm " value="<?= $value['notes'] ?>">
                                            </td>
                                            <td class="text-center">
                                                <input type="hidden" value="0" name="NO_ID[]" id="NO_ID0" class="form-control form-control-sm"> 
                                                <button type="button" class="btn btn-sm btn-circle btn-outline-danger btn-delete" onclick=""> <i class="fa fa-fw fa-trash"></i> </button>
                                            </td>
                                        </tr>
                                        
                                        <?php endforeach; ?>
        
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
        
            <div class="card">
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
    </div>
</div>



<script>

    let deletedImages = [];
    let deletedItems = [];

    
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateType
    );

    const pond = FilePond.create(document.querySelector('.filepond'), {
        name: 'images[]',
        allowMultiple: true,
        maxFiles: 5,
        instantUpload: false,
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/gif'],
        labelFileTypeNotAllowed: 'Hanya gambar yang diizinkan.',
        fileValidateTypeLabelExpectedTypes: 'Format yang diizinkan: PNG, JPG, JPEG, WEBP, GIF',
        files: [
            <?php foreach ($data['sales_order_images'] as $image): ?>
            {
                source: '<?= Env::get('BASE_URL') ?>/images/so/<?= $image['file_name'] ?>',
                options: {
                    type: 'remote',
                    metadata: {
                        imageId: <?= $image['id'] ?>
                    }
                }
            },
            <?php endforeach; ?>
        ],
        allowRemove: true,
        onremovefile: (error, file) => {
            if (!error && file.getMetadata('imageId')) {
                deletedImages.push(file.getMetadata('imageId'));
            }
        }
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
            formData.append('deleted_images', JSON.stringify(deletedImages));
            formData.append('deleted_items', JSON.stringify(deletedItems));

            var id = $("input[name=id]").val();

            $.ajax({
                url: `<?= Env::get('BASE_URL') ?>/sales-order/update/${id}`,
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
    
    var idrow = $('#datatable > tbody > tr').length;

    $('body').on('click', '.btn-delete', function() {
        var r = confirm("Yakin dihapus?");
        if (r == true) {
            var val = $(this).parents("tr").remove();
            idrow--;
        }

        var id = $(this).parents("tr").find("input[name='item_id[]']").val();
        if (id != '') {
            deletedItems.push(id);
        }

    });

    function hapus() {
        if (idrow > 1) {
            var x = document.getElementById('datatable').deleteRow(idrow);
            idrow--;
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

        td01.innerHTML = "<input name='product_desc[]' id=product_desc" + idrow + " type='text' class='form-control form-control-sm '>";
        td02.innerHTML = "<input name='ukuran_pcs[]' id=ukuran_pcs" + idrow + " type='text' class='form-control form-control-sm '>";
        td03.innerHTML = "<input name='panjang_pcs[]' id=panjang_pcs" + idrow + " type='text' class='form-control form-control-sm '>";
        td04.innerHTML = "<input name='gram_pcs[]' id=gram_pcs" + idrow + " type='text' class='form-control form-control-sm ' step='any' value='0'>";
        td05.innerHTML = "<input name='batu_pcs[]' id=batu_pcs" + idrow + " type='text' class='form-control form-control-sm '>";
        td06.innerHTML = "<input name='tok_pcs[]' id=tok_pcs" + idrow + " type='text' class='form-control form-control-sm '>";
        td07.innerHTML = "<input name='color[]' id=color" + idrow + " type='text' class='form-control form-control-sm '>";
        // td08.innerHTML = "<input name='karat[]' id=karat" + idrow + " type='text' class='form-control form-control-sm '>";
        td08.innerHTML = "<input name='pcs[]' id=pcs" + idrow + " type='text' class='form-control form-control-sm ' step='any' value='0'>";
        td09.innerHTML = "<input name='pairs[]' id=pairs" + idrow + " type='text' class='form-control form-control-sm ' step='any' value='0'>";
        td10.innerHTML = "<input name='gram[]' id=gram" + idrow + " type='text' class='form-control form-control-sm ' step='any' value='0'>";
        td11.innerHTML = "<input name='note[]' id=note" + idrow + " type='text' class='form-control form-control-sm '>";
        td12.innerHTML = "<input type='hidden' value='0' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control form-control-sm'>" +
            " <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

        idrow++;
    }
</script>