<?php
use Core\Auth;
use Core\Env;

$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard'; ?></title>
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
    <?= $this->view('layouts/header') ?>
    <link rel="stylesheet" href="<?= Env::get('BASE_URL') ?>/css/style.css">

    <style>

    </style>
</head>
<body>

<?php include __DIR__ . '/sidebar.php'; ?>

<div class="content" id="mainContent">
    <?php include __DIR__ . '/navbar.php'; ?>
    <!-- <div class="container-fluid mt-3"> -->
        <?= $content ?? '' ?>
    <!-- </div> -->
</div>

<div id="overlay">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<script src="<?= Env::get('BASE_URL') ?>/js/app.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
<script>
</script>

</body>
</html>
