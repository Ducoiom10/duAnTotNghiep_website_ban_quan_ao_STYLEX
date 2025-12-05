<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
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
        <!-- Light Logo-->
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
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Sản Phẩm</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-folder-2-line"></i> <span data-key="t-dashboards">Quản lí danh mục</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-link" data-key="t-analytics">
                                    <i class="ri-list-check me-1"></i> Danh sách danh mục
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-analytics"
                                    onclick="openAddCategoryModal()">
                                    <i class="ri-add-circle-line me-1"></i> Thêm mới danh mục
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarProducts">
                        <i class="ri-shopping-bag-line"></i> <span>Quản lý sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-link">
                                    <i class="ri-list-check me-1"></i> Danh sách sản phẩm
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.products.create')); ?>" class="nav-link">
                                    <i class="ri-add-circle-line me-1"></i> Thêm sản phẩm mới
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.products.trash')); ?>" class="nav-link">
                                    <i class="ri-delete-bin-line me-1"></i> Sản phẩm đã xóa
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Quản lý thuộc tính sản phẩm -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAttributes" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAttributes">
                        <i class="ri-palette-line"></i> <span data-key="t-attributes">Thuộc tính sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAttributes">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.colors.index')); ?>" class="nav-link" data-key="t-colors">
                                    <i class="ri-palette-line me-1"></i> Quản lý màu sắc
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.sizes.index')); ?>" class="nav-link" data-key="t-sizes">
                                    <i class="ri-ruler-line me-1"></i> Quản lý kích thước
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.textures.index')); ?>" class="nav-link" data-key="t-textures">
                                    <i class="ri-scissors-line me-1"></i> Quản lý chất liệu
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarInventory" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarInventory">
                        <i class="ri-store-3-line"></i>
                        <span data-key="t-inventory">Quản lý kho hàng</span>

                    </a>
                    <div class="collapse menu-dropdown" id="sidebarInventory">
                        <ul class="nav nav-sm flex-column">
                            
                            <li class="nav-item">
                                <a href="#}" class="nav-link">
                                    <i class="ri-dashboard-line me-1"></i> Tổng quan kho
                                </a>
                            </li>

                            
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="ri-stack-line me-1"></i> Tồn kho hiện tại
                                </a>
                            </li>

                            
                            <li class="nav-item">
                                <a href="#sidebarInOut" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarInOut">
                                    <i class="ri-exchange-line me-1"></i> Nhập / Xuất kho
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarInOut">
                                    <ul class="nav nav-sm flex-column ms-3">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <i class="ri-download-2-line me-1"></i> Nhập kho
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <i class="ri-upload-2-line me-1"></i> Xuất kho
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <i class="ri-arrow-left-right-line me-1"></i> Chuyển kho
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="ri-file-list-3-line me-1"></i> Kiểm kê kho
                                </a>
                            </li>

                            
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="ri-history-line me-1"></i> Lịch sử giao dịch
                                </a>
                            </li>

                            
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="ri-home-4-line me-1"></i> Danh sách kho
                                </a>
                            </li>

                            
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="ri-bar-chart-box-line me-1"></i> Báo cáo kho
                                </a>
                            </li>

                            
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="ri-settings-3-line me-1"></i> Cài đặt kho
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end Dashboard Menu -->

                    <!-- Thuế & Vận chuyển - CHỈ ADMIN -->
                    <?php if(auth()->user()->role == 1): ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTaxShip" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarTaxShip">
                        <i class="ri-truck-line"></i> <span>Thuế & Vận chuyển</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTaxShip">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.tax_rates.index')); ?>" class="nav-link">
                                    <i class="ri-bill-line me-1"></i> Thuế (Tax Rates)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.shipping_carriers.index')); ?>" class="nav-link">
                                    <i class="ri-truck-line me-1"></i> Đơn vị vận chuyển
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Voucher Management -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarVouchers" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarVouchers">
                        <i class="ri-ticket-line"></i> <span>Quản lý voucher</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarVouchers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.vouchers.index')); ?>" class="nav-link">
                                    <i class="ri-list-check me-1"></i> Danh sách voucher
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.vouchers.create')); ?>" class="nav-link">
                                    <i class="ri-add-circle-line me-1"></i> Tạo voucher
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php endif; ?>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Giao diện/Truyền
                        Thông</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Quản lí banner</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.banners.index')); ?>" class="nav-link"
                                    data-key="t-analytics">
                                    <i class="ri-list-check me-1"></i> Danh sách banner
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.banners.create')); ?>" class="nav-link"
                                    data-key="t-analytics"> 
                                    <i class="ri-add-circle-line me-1"></i>
                                    Thêm mới banner
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.banners.trash')); ?>" class="nav-link"
                                    data-key="t-analytics"> 
                                     <i class="ri-delete-bin-line me-1"></i>
                                     Danh sách banner đã xóa
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPosts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarPosts">
                        <i class="ri-pages-line"></i> <span>Quản lí bài viết</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPosts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.posts.index')); ?>" class="nav-link">
                                    <i class="ri-list-check me-1"></i> Danh sách bài viết
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.posts.create')); ?>" class="nav-link">
                                    <i class="ri-add-circle-line me-1"></i> Thêm bài viết mới
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.posts.trash')); ?>" class="nav-link">
                                    <i class="ri-add-circle-line me-1"></i> Danh sách bài viết đã xóa
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Khách hàng và đơn
                        hàng</span>
                </li>

                <!-- Quản lí người dùng - ADMIN và STAFF -->
                <?php if(auth()->user()->role == 1 || auth()->user()->role == 2): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarUI" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarUI">
                            <i class="ri-account-circle-line"></i> <span data-key="t-base-ui">Quản lí người
                                dùng</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarUI">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link"
                                        data-key="t-analytics">
                                        <i class="ri-user-line me-1"></i> Danh sách người dùng
                                    </a>
                                </li>
                                <?php if(auth()->user()->role == 1): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('admin.users.create')); ?>" class="nav-link"
                                            data-key="t-analytics">
                                            <i class="ri-user-add-line me-1"></i> Tạo User mới
                                            <small class="text-muted d-block">(Chỉ tạo User)</small>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('admin.users.trash')); ?>" class="nav-link"
                                            data-key="t-analytics">
                                            Danh sách người dùng đã xóa
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Quản lý phân quyền - CHỈ ADMIN -->
                <?php if(auth()->user()->role == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarManagement" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarManagement">
                            <i class="ri-settings-3-line"></i> <span>Quản Lý Quyền Hạn</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarManagement">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('admin.roles.index')); ?>" class="nav-link">
                                        <i class="ri-user-settings-line me-1"></i> Phân quyền người dùng
                                        <small class="text-muted d-block">(Gán role cho user)</small>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('admin.rbac.roles.index')); ?>" class="nav-link">
                                        <i class="ri-shield-star-line me-1"></i> Quản lý Roles (Entity)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('admin.rbac.permissions.index')); ?>" class="nav-link">
                                        <i class="ri-key-2-line me-1"></i> Quản lý Permissions (Entity)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Cấp độ thành viên - CHỈ ADMIN -->
                <?php if(auth()->user()->role == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarLoyalty" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarLoyalty">
                            <i class="ri-vip-crown-line"></i> <span data-key="t-loyalty">Cấp độ thành viên</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLoyalty">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('admin.loyalty-tiers.index')); ?>" class="nav-link"
                                        data-key="t-loyalty-list">
                                        Danh sách cấp độ
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('admin.loyalty-tiers.create')); ?>" class="nav-link"
                                        data-key="t-loyalty-create">
                                        Thêm cấp độ mới
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarOrders">
                        <i class="ri-shopping-bag-3-line"></i>
                        <span data-key="t-orders">Quản lý đơn hàng</span>
                    </a>

                    <div class="collapse menu-dropdown" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-link"
                                    data-key="t-orders-list">
                                    Danh sách đơn hàng
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarForms">
                        <i class="ri-file-list-3-line"></i> <span data-key="t-forms">Quản lí đánh giá</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarForms">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="forms-elements.html" class="nav-link" data-key="t-basic-elements">Basic
                                    Elements</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-select.html" class="nav-link" data-key="t-form-select"> Form Select
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-checkboxs-radios.html" class="nav-link"
                                    data-key="t-checkboxs-radios">Checkboxs & Radios</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-pickers.html" class="nav-link" data-key="t-pickers"> Pickers </a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-masks.html" class="nav-link" data-key="t-input-masks">Input Masks</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-advanced.html" class="nav-link" data-key="t-advanced">Advanced</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-range-sliders.html" class="nav-link" data-key="t-range-slider"> Range
                                    Slider </a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-validation.html" class="nav-link"
                                    data-key="t-validation">Validation</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-wizard.html" class="nav-link" data-key="t-wizard">Wizard</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-editors.html" class="nav-link" data-key="t-editors">Editors</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-file-uploads.html" class="nav-link" data-key="t-file-uploads">File
                                    Uploads</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-layouts.html" class="nav-link" data-key="t-form-layouts">Form
                                    Layouts</a>
                            </li>
                            <li class="nav-item">
                                <a href="forms-select2.html" class="nav-link" data-key="t-select2">Select2</a>
                            </li>
                        </ul>
                    </div>
                </li>
        </ul>
    </div>
    <!-- Sidebar -->
</div>

<div class="sidebar-background"> </div>
</div>


<link rel="stylesheet" href="<?php echo e(asset('assets/css/style-x-logo.css')); ?>">
<script src="<?php echo e(asset('assets/js/sidebar-menu.js')); ?>"></script>
<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\partials\sidebar.blade.php ENDPATH**/ ?>