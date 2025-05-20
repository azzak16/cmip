<?php

use Core\Auth;
use Core\Env;
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <!-- <li class="nav-item d-none d-sm-inline-block">
      <a href="../../index3.html" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> -->
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li> -->

    <li class="nav-item dropdown">
      <button class="btn nav-link dropdown-toggle mr-md-2" data-toggle="dropdown" aria-expanded="true">
        <i class="fas fa-user"></i> 
      </button>
      <div class="dropdown-menu dropdown-menu-md-right">
        <a class="dropdown-item" href="<?= Env::get('BASE_URL') ?>/user/setting/<?= $_SESSION['user']['NO_ID'] ?>">Setting</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?= Env::get('BASE_URL') ?>/logout">Log Out</a>
      </div>
    </li>

  </ul>
</nav>
<!-- /.navbar -->