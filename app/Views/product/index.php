<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"> -->

<a href="<?= \Core\Env::get('BASE_URL')?>/products/create" class="btn btn-primary mb-3">+ Tambah Produk</a>

<table class="table table-bordered" id="productTable">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>

<!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script> -->
<script>
    $('#productTable').DataTable({
        ajax: '/products/data',
        columns: [
            { data: 'name' },
            { data: 'description' },
            {
                data: 'id',
                render: function(id) {
                    return `<form method="POST" action="/products/delete/${id}" onsubmit="return confirm('Yakin?')">
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>`;
                }
            }
        ]
    });
</script>
