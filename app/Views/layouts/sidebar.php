<div class="bg-dark text-white position-fixed h-100 sidebar" id="sidebar">
    <div class="p-3 d-flex align-items-center justify-content-between">
        <span class="font-weight-bold">CMIP</span>
    </div>
    <ul class="nav flex-column px-2">
        <li class="nav-item">
            <a href="<?= \Core\Env::get('BASE_URL') ?>/dashboard" class="nav-link text-white">
                <i class="fas fa-tachometer-alt"></i> <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= \Core\Env::get('BASE_URL') ?>/products" class="nav-link text-white">
                <i class="fas fa-box"></i> <span class="menu-text">Product</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= \Core\Env::get('BASE_URL') ?>/sales-order" class="nav-link text-white">
                <i class="fas fa-box"></i> <span class="menu-text">Saless Order</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/logout" class="nav-link text-white">
                <i class="fas fa-sign-out-alt"></i> <span class="menu-text">Logout</span>
            </a>
        </li>
    </ul>
</div>
