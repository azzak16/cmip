<?php

use Core\Env;
?>
<link rel="stylesheet" href="<?= Env::get('BASE_URL') ?>/assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">
<link rel="stylesheet" href="<?= Env::get('BASE_URL') ?>/assets/sweetalert2/dist/sweetalert2.min.css">

<body class="login-page" style="min-height: 496.781px;">
    <div class="login-box">
        <div class="login-logo">
            <b>CMIP</b>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form method="post" id="form">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <script src="<?= Env::get('BASE_URL') ?>/assets/jquery/jquery-3.7.1.min.js"></script>
    <script src="<?= Env::get('BASE_URL') ?>/assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= Env::get('BASE_URL') ?>/assets/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
    <script src="<?= Env::get('BASE_URL') ?>/js/app.js"></script>

    <script>
        $(document).ready(function () {
            
            $('#form').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: '<?= Env::get('BASE_URL') ?>/login',
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

        })
    </script>

</body>

