<div class="navbar-header">
    <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box horizontal-logo">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo logo-dark">
                <span class="logo-sm">
                    <div class="style-x-logo-sm">
                        <span class="style-text">S</span>
                        <span class="x-text">X</span>
                    </div>
                </span>
                <span class="logo-lg">
                    <div class="style-x-logo-lg">
                        <span class="style-text">Style</span>
                        <span class="x-text">X</span>
                    </div>
                </span>
            </a>

            <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo logo-light">
                <span class="logo-sm">
                    <div class="style-x-logo-sm">
                        <span class="style-text">S</span>
                        <span class="x-text">X</span>
                    </div>
                </span>
                <span class="logo-lg">
                    <div class="style-x-logo-lg">
                        <span class="style-text">Style</span>
                        <span class="x-text">X</span>
                    </div>
                </span>
            </a>
        </div>

        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
            id="topnav-hamburger-icon">
            <span class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>

        <!-- App Search-->
        <form class="app-search d-none d-md-block">
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                    id="search-options" value="">
                <span class="mdi mdi-magnify search-widget-icon"></span>
                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                    id="search-close-options"></span>
            </div>
        </form>
    </div>

    <div class="d-flex align-items-center">
        <div class="dropdown d-md-none topbar-head-dropdown header-item">
            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-search fs-22"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                aria-labelledby="page-header-search-dropdown">
                <form class="p-3">
                    <div class="form-group m-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search ..."
                                aria-label="Recipient's username">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="ms-1 header-item d-none d-sm-flex">
            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                data-toggle="fullscreen">
                <i class='bx bx-fullscreen fs-22'></i>
            </button>
        </div>

        <div class="ms-1 header-item d-none d-sm-flex">
            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                <i class='bx bx-moon fs-22'></i>
            </button>
        </div>


        <div class="dropdown ms-sm-3 header-item topbar-user">
            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="d-flex align-items-center">

                    <img class="rounded-circle header-profile-user" src="<?php echo e(Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : \App\Http\Controllers\Admin\UserController::URLIMAGEDEFAULT); ?>"
                        alt="Header Avatar">
                    <span class="text-start ms-xl-2">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                            <?php echo e(Auth::user()->name ?? null); ?>

                            <?php if(Auth::user()->role == 1): ?>
                                <span class="badge bg-danger ms-1">Admin</span>
                            <?php elseif(Auth::user()->role == 2): ?>
                                <span class="badge bg-warning ms-1">Staff</span>
                            <?php else: ?>
                                <span class="badge bg-info ms-1">User</span>
                            <?php endif; ?>
                        </span>
                        <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?php echo e(Auth::user()->email ?? null); ?></span>
                    </span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->

                <h6 class="dropdown-header">
                    <?php if(Auth::user()->role == 1): ?>
                        Xin chào Admin <?php echo e(Auth::user()->name ?? null); ?>! 
                    <?php elseif(Auth::user()->role == 2): ?>
                        Xin chào Staff <?php echo e(Auth::user()->name ?? null); ?>! 
                    <?php else: ?>
                        Xin chào <?php echo e(Auth::user()->name ?? null); ?>! 
                    <?php endif; ?>
                </h6>
                <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>"><i
                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                        class="align-middle">Thông tin cá nhân</span></a>    
                        <a class="dropdown-item" href="#">
                        <i
                        class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                        class="align-middle">Cài đặt</span></a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="dropdown-item" type="submit">
                        <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo e(asset('assets/css/style-x-logo.css')); ?>">
<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\partials\navbar.blade.php ENDPATH**/ ?>