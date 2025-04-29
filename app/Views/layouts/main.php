<?php
use Core\Auth;
$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard'; ?></title>
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="/assets/style.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            transition: all 0.3s;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar .menu-text {
            display: inline;
            transition: all 0.3s;
        }
        .sidebar.collapsed .menu-text {
            display: none;
        }
        .content {
            margin-left: 250px;
            transition: all 0.3s;
        }
        .content.collapsed {
            margin-left: 80px;
        }
    </style>
    <?= $this->view('layouts/header') ?>
</head>
<body>

<?php include __DIR__ . '/sidebar.php'; ?>

<div class="content" id="mainContent">
    <?php include __DIR__ . '/navbar.php'; ?>
    <div class="container-fluid mt-3">
        <?= $content ?? '' ?>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('mainContent');

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    });
</script>

</body>
</html>
