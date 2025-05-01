<?php

use Core\Env;
?>

<a href="<?= \Core\Env::get('BASE_URL') ?>/sales-order/create" class="btn btn-primary mb-3">+ Tambah Sales Order</a>

<table class="table table-bordered" id="table-product">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>

<script>
    var datatable = $('#table-product').DataTable({
        ajax: '<?= Env::get('BASE_URL') ?>/sales-order/data',
        columns: [{
                data: 'name'
            },
            {
                data: 'category_id'
            },
            {
                data: 'description'
            },
            {
                data: 'id',
                render: function(data, type, row, meta) {

                    var html = `<div>
                                    <a href="<?= Env::get('BASE_URL') ?>/sales-order/edit/${row.id}" class="btn btn-sm btn-info btn-edit" >Edit</a>
                                    <a class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Delete</a>
                                </div>`;

                    return html;
                }
            }
        ]
    });

    // $('#table-product').on('click', '.btn-edit', function() {
    //     var id = $(this).data('id');
    //     $.get(`<?= Env::get('BASE_URL') ?>/sales-order/edit/${id}`, function(res) {
    //         $('[name="id"]').val(res.id);
    //         $('[name="name"]').val(res.name);
    //         $('[name="price"]').val(res.price);
    //         var newOption = new Option(res.category_name, res.category_id, true, true);
    //         $('[name="category_id"]').append(newOption).trigger('change');

    //         $('#modalForm').modal('show');
    //     });
    // });

    $('#table-product').on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        if (confirm('Yakin hapus produk ini?')) {

            $.ajax({
                url: `<?= Env::get('BASE_URL') ?>/sales-order/delete/${id}`,
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

                    datatable.ajax.reload();
                },
                error: function(xhr) {
                    const err = JSON.parse(xhr.responseText);
                    Toast.fire({
                        icon: "warning",
                        title: err.message
                    });
                }
            });
        }
    });
</script>