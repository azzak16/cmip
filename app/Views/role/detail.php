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
        
                            <div class="form-group col-md-12">
                                <label class="col-form-label col-form-label-sm" for="name">Nama</label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm" readonly value="<?= $role['name'] ?>">
                                <input type="hidden" id="id" value="<?= $role['id'] ?>">
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-form-label col-form-label-sm col-md-6" style="margin-left: -15px" for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" id="description" readonly><?= $role['description'] ?></textarea>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data['permission'] as $key => $value) : ?>
                                        <tr>
                                            <td><?= $key ?></td>
                                            <td>
                                            <?php foreach($value as $val) : ?>
                                                <a href="#" class="btn btn-outline-info update-permission" data-active="0" data-menu="<?= $key ?>" data-name="<?= $val ?>"><?= $val ?></a>
                                            <?php endforeach ?>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
        
                    </div>
                </div>
            </div>
        
        </form>
    </div>
</div>



<script>
    

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

        $(document).on('click','.update-permission',function(e){
            e.preventDefault();

            var button = $(this);
            var id = $('#id').val();
            var menu = button.data('menu');
            var name = button.data('name');
            var active = button.attr('data-active');
            
            $.ajax({
                url: `<?= Env::get('BASE_URL') ?>/role/permission/${id}`,
                method: 'POST',
                cache: false,
                data: {
                    menu : menu,
                    name : name,
                    active : active,
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#overlay').removeClass('d-none');
                },
                complete: function() {
                    $('#overlay').addClass('d-none');
                },
                success: function(res) {

                    if (res.aksi === 'update') {
                        button.addClass('active');
                        button.attr('data-active', 1);
                    }else{
                        button.removeClass('active');
                        button.attr('data-active', 0);
                    }
                    

                    Toast.fire({
                        icon: "success",
                        title: res.message
                    });
                    // window.location.href = res.redirect;
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

    });

</script>