<?php

use Core\Env;
?>
<div class="row">
    <div class="col-md-12">
        <form id="form" method="post" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Setting</h5>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputName" placeholder="Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Navbar Variants</label>
                            <div class="col-sm-10">
                                <select id="navbarVariant" class="custom-select mb-3 border-0">
                                    <option>None Selected</option>
                                    <option class="bg-primary">Primary</option>
                                    <option class="bg-secondary">Secondary</option>
                                    <option class="bg-info">Info</option>
                                    <option class="bg-success">Success</option>
                                    <option class="bg-danger">Danger</option>
                                    <option class="bg-indigo">Indigo</option>
                                    <option class="bg-purple">Purple</option>
                                    <option class="bg-pink">Pink</option>
                                    <option class="bg-navy">Navy</option>
                                    <option class="bg-lightblue">Lightblue</option>
                                    <option class="bg-teal">Teal</option>
                                    <option class="bg-cyan">Cyan</option>
                                    <option class="bg-dark">Dark</option>
                                    <option class="bg-gray-dark">Gray dark</option>
                                    <option class="bg-gray">Gray</option>
                                    <option class="bg-light">Light</option>
                                    <option class="bg-warning">Warning</option>
                                    <option class="bg-white">White</option>
                                    <option class="bg-orange">Orange</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Accent Color Variants</label>
                            <div class="col-sm-10">
                                <select id="accentColor" class="custom-select mb-3 border-0">
                                    <option>None Selected</option>
                                    <option class="bg-primary">Primary</option>
                                    <option class="bg-warning">Warning</option>
                                    <option class="bg-info">Info</option>
                                    <option class="bg-danger">Danger</option>
                                    <option class="bg-success">Success</option>
                                    <option class="bg-indigo">Indigo</option>
                                    <option class="bg-lightblue">Lightblue</option>
                                    <option class="bg-navy">Navy</option>
                                    <option class="bg-purple">Purple</option>
                                    <option class="bg-fuchsia">Fuchsia</option>
                                    <option class="bg-pink">Pink</option>
                                    <option class="bg-maroon">Maroon</option>
                                    <option class="bg-orange">Orange</option>
                                    <option class="bg-lime">Lime</option>
                                    <option class="bg-teal">Teal</option>
                                    <option class="bg-olive">Olive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Dark Sidebar Variants</label>
                            <div class="col-sm-10">
                                <select id="darkSidebarVariant" class="custom-select mb-3 text-light border-0 bg-primary">
                                    <option>None Selected</option>
                                    <option class="bg-primary">Primary</option>
                                    <option class="bg-warning">Warning</option>
                                    <option class="bg-info">Info</option>
                                    <option class="bg-danger">Danger</option>
                                    <option class="bg-success">Success</option>
                                    <option class="bg-indigo">Indigo</option>
                                    <option class="bg-lightblue">Lightblue</option>
                                    <option class="bg-navy">Navy</option>
                                    <option class="bg-purple">Purple</option>
                                    <option class="bg-fuchsia">Fuchsia</option>
                                    <option class="bg-pink">Pink</option>
                                    <option class="bg-maroon">Maroon</option>
                                    <option class="bg-orange">Orange</option>
                                    <option class="bg-lime">Lime</option>
                                    <option class="bg-teal">Teal</option>
                                    <option class="bg-olive">Olive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Light Sidebar Variants</label>
                            <div class="col-sm-10">
                                <select id="lightSidebarVariant" class="custom-select mb-3 border-0">
                                    <option>None Selected</option>
                                    <option class="bg-primary">Primary</option>
                                    <option class="bg-warning">Warning</option>
                                    <option class="bg-info">Info</option>
                                    <option class="bg-danger">Danger</option>
                                    <option class="bg-success">Success</option>
                                    <option class="bg-indigo">Indigo</option>
                                    <option class="bg-lightblue">Lightblue</option>
                                    <option class="bg-navy">Navy</option>
                                    <option class="bg-purple">Purple</option>
                                    <option class="bg-fuchsia">Fuchsia</option>
                                    <option class="bg-pink">Pink</option>
                                    <option class="bg-maroon">Maroon</option>
                                    <option class="bg-orange">Orange</option>
                                    <option class="bg-lime">Lime</option>
                                    <option class="bg-teal">Teal</option>
                                    <option class="bg-olive">Olive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Brand Logo Variants</label>
                            <div class="col-sm-10">
                                <select id="brandLogoVariant" class="custom-select mb-3 border-0">
                                    <option>None Selected</option>
                                    <option class="bg-primary">Primary</option>
                                    <option class="bg-secondary">Secondary</option>
                                    <option class="bg-info">Info</option>
                                    <option class="bg-success">Success</option>
                                    <option class="bg-danger">Danger</option>
                                    <option class="bg-indigo">Indigo</option>
                                    <option class="bg-purple">Purple</option>
                                    <option class="bg-pink">Pink</option>
                                    <option class="bg-navy">Navy</option>
                                    <option class="bg-lightblue">Lightblue</option>
                                    <option class="bg-teal">Teal</option>
                                    <option class="bg-cyan">Cyan</option>
                                    <option class="bg-dark">Dark</option>
                                    <option class="bg-gray-dark">Gray dark</option>
                                    <option class="bg-gray">Gray</option>
                                    <option class="bg-light">Light</option>
                                    <option class="bg-warning">Warning</option>
                                    <option class="bg-white">White</option>
                                    <option class="bg-orange">Orange</option><a href="#">clear</a>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div><!-- /.card-body -->
    </div>

    </form>
</div>

<!-- <script src="<?= Env::get('BASE_URL') ?>/assets/AdminLTE-3.2.0/build/js/ControlSidebar.js"></script> -->

<script>
  $(function () {
    const body = $('body');
    const navbar = $('.main-header');
    const sidebar = $('.main-sidebar');
    const brand = $('.brand-link');

    // NAVBAR
    $('#navbarVariant').on('change', function () {
      const selected = $(this).val().toLowerCase();
      navbar.removeClass(function (index, className) {
        return (className.match(/(^|\s)navbar-(\S+)/g) || []).join(' ');
      }).addClass('navbar-' + selected);
    });

    // ACCENT COLOR
    $('#accentColor').on('change', function () {
      const selected = $(this).val().toLowerCase();
      body.removeClass(function (index, className) {
        return (className.match(/(^|\s)accent-(\S+)/g) || []).join(' ');
      });
      if (selected !== 'none selected') {
        body.addClass('accent-' + selected);
      }
    });

    // DARK SIDEBAR
    $('#darkSidebarVariant').on('change', function () {
      const selected = $(this).val().toLowerCase();
      sidebar.removeClass(function (index, className) {
        return (className.match(/(^|\s)sidebar-dark-(\S+)/g) || []).join(' ');
      }).addClass('sidebar-dark-' + selected);
    });

    // LIGHT SIDEBAR
    $('#lightSidebarVariant').on('change', function () {
      const selected = $(this).val().toLowerCase();
      sidebar.removeClass(function (index, className) {
        return (className.match(/(^|\s)sidebar-light-(\S+)/g) || []).join(' ');
      }).addClass('sidebar-light-' + selected);
    });

    // BRAND LOGO
    $('#brandLogoVariant').on('change', function () {
      const selected = $(this).val().toLowerCase();
      brand.removeClass(function (index, className) {
        return (className.match(/(^|\s)navbar-(\S+)/g) || []).join(' ');
      }).addClass('navbar-' + selected);
    });
  });
</script>


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


    });
</script>