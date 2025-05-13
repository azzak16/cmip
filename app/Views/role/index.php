<?php

use Core\Env;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?= $data['title'] ?? 'Dashboard'; ?></h5>
            </div>
            <div class="card-body row">
                <div class="col-md-12">
                    <a href="<?= \Core\Env::get('BASE_URL') ?>/role/create" class="btn btn-primary btn-sm mb-3 float-right">+ Tambah</a>
                </div>
                
                <div class="col-md-12">
                    <table class="table table-sm" id="datatable">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Desc</th>
                            <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var datatable = $('#datatable').DataTable({
        ajax: '<?= Env::get('BASE_URL') ?>/role/data',
        columns: [
            {
                data: 'name'
            },
            {
                data: 'description'
            },
            {
                data: 'id',
                className: 'text-center',
                render: function(data, type, row, meta) {

                    var html = `<div>
                                    <a href="<?= Env::get('BASE_URL') ?>/role/edit/${row.id}" class="btn btn-sm btn-outline-info btn-edit" ><i class="fas fa-pencil"></i></a>
                                    <a href="<?= Env::get('BASE_URL') ?>/role/view/${row.id}" class="btn btn-sm btn-outline-warning btn-view" ><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-sm btn-outline-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash"></i></a>
                                </div>`;

                    return html;
                }
            }
        ]
    });

    $('#datatable').on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        if (confirm('Yakin hapus produk ini?')) {

            $.ajax({
                url: `<?= Env::get('BASE_URL') ?>/role/delete/${id}`,
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