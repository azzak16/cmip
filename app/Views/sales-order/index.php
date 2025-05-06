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
                <a href="<?= \Core\Env::get('BASE_URL') ?>/sales-order/create" class="btn btn-primary btn-sm mb-3 float-right">+ Tambah</a>
            </div>
            
            <div class="col-md-12">
                <table class="table table-sm" id="datatable">
                <thead>
                    <tr>
                        <th>Kode Produksi</th>
                        <th>Nomer Order</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    var datatable = $('#datatable').DataTable({
        ajax: '<?= Env::get('BASE_URL') ?>/sales-order/data',
        columns: [
            {
                data: 'production_code'
            },
            {
                data: 'order_number'
            },
            {
                data: 'id',
                className: 'text-center',
                render: function(data, type, row, meta) {

                    var html = '';

                    if (row.status == 'DRAFT') {
                        html = `<h5><span class="badge badge-secondary">${row.status}</span></h5>`
                    }else{
                        html = `<h5><span class="badge badge-warning">${row.status}</span></h5>`
                    }

                    return html;
                }
            },
            {
                data: 'id',
                className: 'text-center',
                render: function(data, type, row, meta) {

                    var html = `<div>
                                    <a href="<?= Env::get('BASE_URL') ?>/sales-order/edit/${row.id}" class="btn btn-sm btn-info btn-edit" >Edit</a>
                                    <a class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Delete</a>
                                    <a href="<?= Env::get('BASE_URL') ?>/sales-order/print/${row.id}" target="_blank" class="btn btn-sm btn-primary">Print</a>
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