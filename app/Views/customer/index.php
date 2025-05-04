<?php
use Core\Env;
?>

<div class="m-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><?= $data['title'] ?? 'Dashboard'; ?></h5>
        </div>
        <div class="card-body row">
            <div class="col-md-12">
                <a href="<?= \Core\Env::get('BASE_URL') ?>/products/create" class="btn btn-primary btn-sm mb-3 float-right">+ Tambah Produk</a>
            </div>
            
            <div class="col-md-12">
                <table class="table table-sm" id="table-product">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    var datatable = $('#table-product').DataTable({
        ajax: '<?= Env::get('BASE_URL') ?>/products/data',
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
                className: 'text-center',
                render: function(data, type, row, meta) {

                    var html = `<div>
                                    <a href="<?= Env::get('BASE_URL') ?>/products/edit/${row.id}" class="btn btn-sm btn-outline-info btn-edit" ><i class="fas fa-pencil"></i></a>
                                    <a class="btn btn-sm btn-outline-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash"></i></a>
                                </div>`;

                    return html;
                }
            }
        ]
    });

    // $('#table-product').on('click', '.btn-edit', function() {
    //     var id = $(this).data('id');
    //     $.get(`<?= Env::get('BASE_URL') ?>/products/edit/${id}`, function(res) {
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
                url: `<?= Env::get('BASE_URL') ?>/products/delete/${id}`,
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