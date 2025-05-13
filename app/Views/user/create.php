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
        
                            <div class="form-group col-md-3">
                                <label class="col-form-label col-form-label-sm" for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control form-control-sm">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="col-form-label col-form-label-sm col-md-6" style="margin-left: -15px" for="karat_id">Kadar</label>
                                <select name="karat_id" id="karat_id" class="form-control form-control-sm karat-select2" ></select>
                            </div>
        
                            <div class="form-group col-md-6">
                                <label class="col-form-label col-form-label-sm col-md-6" style="margin-left: -15px" for="status">Status</label>
                                <select name="status" id="status" class="form-control form-control-sm select2" >
                                    <option value="DRAFT" selected>Draft</option>
                                    <option value="SPK">SPK</option>
                                </select>
                            </div>
                        </div>
        
                        <button type="submit" class="btn btn-primary mt-3 col-md-6 float-right">Simpan</button>
                    </div>
                </div>
            </div>
        
        </form>
    </div>
</div>



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
            // console.log(formData);
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
        if (idrow > 1) {
            var val = $(this).parents("tr").remove();
            idrow--;
            // hitung();
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

        td01.innerHTML = "<input name='product_desc[]' id=product_desc" + idrow + " type='text' class='form-control form-control-sm'>";
        td02.innerHTML = "<input name='ukuran_pcs[]' id=ukuran_pcs" + idrow + " type='text' class='form-control form-control-sm'>";
        td03.innerHTML = "<input name='panjang_pcs[]' id=panjang_pcs" + idrow + " type='text' class='form-control form-control-sm'>";
        td04.innerHTML = "<input name='gram_pcs[]' id=gram_pcs" + idrow + " type='text' class='form-control form-control-sm' step='any' value='0'>";
        td05.innerHTML = "<input name='batu_pcs[]' id=batu_pcs" + idrow + " type='text' class='form-control form-control-sm'>";
        td06.innerHTML = "<input name='tok_pcs[]' id=tok_pcs" + idrow + " type='text' class='form-control form-control-sm'>";
        td07.innerHTML = "<input name='color[]' id=color" + idrow + " type='text' class='form-control form-control-sm'>";
        // td08.innerHTML = "<input name='karat[]' id=karat" + idrow + " type='text' class='form-control form-control-sm'>";
        td08.innerHTML = "<input name='pcs[]' id=pcs" + idrow + " type='text' class='form-control form-control-sm' step='any' value='0'>";
        td09.innerHTML = "<input name='pairs[]' id=pairs" + idrow + " type='text' class='form-control form-control-sm' step='any' value='0'>";
        td10.innerHTML = "<input name='gram[]' id=gram" + idrow + " type='text' class='form-control form-control-sm' step='any' value='0'>";
        td11.innerHTML = "<input name='note[]' id=note" + idrow + " type='text' class='form-control form-control-sm'>";
        td12.innerHTML = "<input type='hidden' value='0' name='NO_ID[]' id=NO_ID" + idrow + "  class='form-control form-control-sm'>" +
            " <button type='button' class='btn btn-sm btn-circle btn-outline-danger btn-delete' onclick=''> <i class='fa fa-fw fa-trash'></i> </button>";

        idrow++;
    }
</script>