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
                                <label class="col-form-label col-form-label-sm" for="menu">Menu</label>
                                <input type="text" name="menu" id="menu" class="form-control form-control-sm">
                            </div>

                            <div class="form-group col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="name[]" value="detail">
                                    <label class="form-check-label" for="inlineCheckbox1">Detail</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="name[]" value="create">
                                    <label class="form-check-label" for="inlineCheckbox2">Create</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="name[]" value="edit">
                                    <label class="form-check-label" for="inlineCheckbox2">Edit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="name[]" value="delete">
                                    <label class="form-check-label" for="inlineCheckbox2">Delete</label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="col-form-label col-form-label-sm" for="description">Description</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
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
            // console.log(formData);
            $.ajax({
                url: '<?= Env::get('BASE_URL') ?>/permission/store',
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

        


    });

    
</script>