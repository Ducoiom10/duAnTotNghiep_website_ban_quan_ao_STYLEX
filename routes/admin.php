<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TextureController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleEntityController;
use App\Http\Controllers\Admin\PermissionEntityController;
use App\Http\Controllers\Admin\LoyaltyTierController;
use App\Http\Controllers\Admin\TaxRateController;
use App\Http\Controllers\Admin\ShippingCarrierController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\StockInController;
use App\Http\Controllers\Admin\StockOutController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\CountController;
use App\Http\Controllers\Admin\DefectAssessmentController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\StockOutInvoiceController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\NotificationController;

// Admin và Staff routes - cả hai đều có thể truy cập
Route::group(['middleware' => ['onlyAuthenticated', 'checkRole:1,2']], function () {
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //Categories route
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/admin-category-create', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

        // Colors, Sizes, Textures routes
        Route::resource('colors', ColorController::class);
        Route::resource('sizes', SizeController::class);
        Route::resource('textures', TextureController::class);

        // Products routes
        Route::prefix('products')->as('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/trash', [ProductController::class, 'trash'])->name('trash');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::get('/{product}', [ProductController::class, 'show'])->name('show');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::post('/filter', [ProductController::class, 'filter'])->name('filter');
            Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
            Route::post('/{product}/toggle-feature', [ProductController::class, 'toggleFeature'])->name('toggleFeature');
            Route::patch('/{id}/restore', [ProductController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('force-delete');

            // Nén/resize ảnh
            Route::post('/{product}/images', [ProductImageController::class, 'storeProduct'])
                ->name('images.store');
        });
        // Nén/resize ảnh cho variant-image
        Route::post('/variants/{variant}/images', [ProductImageController::class, 'storeVariant'])
            ->name('variants.images.store');

        // Profile routes - Admin và Staff đều có thể chỉnh sửa thông tin cá nhân
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

        // Banners routes
        Route::prefix('banners')->as('banners.')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('index');
            Route::get('/trash', [BannerController::class, 'trash'])->name('trash');
            Route::get('/create', [BannerController::class, 'create'])->name('create');
            Route::get('/{banner}', [BannerController::class, 'show'])->name('show');
            Route::post('/store', [BannerController::class, 'store'])->name('store');
            Route::post('/update-order', [BannerController::class, 'updateOrder'])->name('updateOrder');
            Route::get('/edit/{banner}', [BannerController::class, 'edit'])->name('edit');
            Route::put('/{banner}', [BannerController::class, 'update'])->name('update');
            Route::delete('/{banner}', [BannerController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/restore', [BannerController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [BannerController::class, 'forceDelete'])->name('force-delete');
        });

        // Post routes
        Route::prefix('posts')->as('posts.')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('/trash', [PostController::class, 'trash'])->name('trash');
            Route::get('/create', [PostController::class, 'create'])->name('create');
            Route::get('/{id}', [PostController::class, 'show'])->name('show');
            Route::post('/store', [PostController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PostController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PostController::class, 'update'])->name('update');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/restore', [PostController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [PostController::class, 'forceDelete'])->name('force-delete');
        });
        // Reviews routes
        Route::prefix('reviews')->as('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::get('/{review}', [ReviewController::class, 'show'])->name('show');
            Route::patch('/{id}/toggle-status', [ReviewController::class, 'toggleStatus'])
                ->name('toggleStatus');
            Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
        });
    });
});

// Users management - CHUNG cho cả ADMIN và STAFF
Route::group(['middleware' => ['onlyAuthenticated', 'checkRole:1,2']], function () {
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
        });
    });
});

// Routes chỉ dành cho Admin (role=1) - Bổ sung thêm chức năng
Route::group(['middleware' => ['onlyAuthenticated', 'checkRole:1']], function () {
    Route::prefix('admin')->as('admin.')->group(function () {
        // Role Management - CHỈ ADMIN
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{user}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{user}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{user}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/roles/check-admin-count', [RoleController::class, 'checkAdminCount'])->name('roles.check-admin-count');
        Route::post('/roles/{user}/update-role', [RoleController::class, 'updateRole'])->name('roles.update-role');
        Route::post('/roles/bulk-update', [RoleController::class, 'bulkUpdateRoles'])->name('roles.bulk-update');

        // Loyalty Tiers - CHỈ ADMIN
        Route::resource('loyalty-tiers', LoyaltyTierController::class)
            ->parameters(['loyalty-tiers' => 'loyaltyTier']);

        // Tax & Shipping routes - CHỈ ADMIN
        Route::resource('tax_rates', TaxRateController::class);
        Route::resource('shipping_carriers', ShippingCarrierController::class);
        // Voucher routes - CHỈ ADMIN
        Route::resource('vouchers', VoucherController::class);

        // RBAC Entities (roles & permissions) - CHỈ ADMIN, entity management only
        Route::prefix('rbac')->as('rbac.')->group(function () {
            Route::resource('roles', RoleEntityController::class)->except(['show']);
            Route::resource('permissions', PermissionEntityController::class)->except(['show']);
        });

        // Orders management
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        //Route Users - CHỈ ADMIN (bổ sung thêm chức năng)
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/trash', [UserController::class, 'trash'])->name('trash');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::post('/filter', [UserController::class, 'filter'])->name('filter');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            Route::put('/updateEmailVerified/{user}', [UserController::class, 'updateEmailVerified'])->name('updateEmailVerified');
            Route::patch('/{id}/restore', [UserController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [UserController::class, 'forceDelete'])->name('force-delete');
        });

        Route::prefix('inventory')->as('inventory.')->group(function () {
            Route::get('/', [InventoryController::class, 'index'])->name('index');
            Route::get('dashboard', [InventoryController::class, 'dashboard'])->name('dashboard');
            Route::get('logs', [InventoryController::class, 'showLogs'])->name('logs');

            Route::prefix('stock-in')->as('stock-in.')->group(function () {
                Route::get('/', [StockInController::class, 'index'])->name('index');
                Route::get('create', [StockInController::class, 'create'])->name('create');
                Route::post('/', [StockInController::class, 'store'])->name('store');
                Route::get('{id}/qc', [StockInController::class, 'qc'])->name('qc');
                Route::post('{id}/confirm-qc', [StockInController::class, 'confirmQC'])->name('confirm-qc');
                Route::post('{id}/confirm', [StockInController::class, 'confirm'])->name('confirm');
            });

            Route::prefix('stock-out')->as('stock-out.')->group(function () {
                Route::get('/', [StockOutController::class, 'index'])->name('index');
                Route::get('create', [StockOutController::class, 'create'])->name('create');
                Route::post('/', [StockOutController::class, 'store'])->name('store');
                Route::get('{id}/qc', [StockOutController::class, 'qc'])->name('qc');
                Route::post('{id}/confirm-qc', [StockOutController::class, 'confirmQC'])->name('confirm-qc');
                Route::post('{id}/confirm', [StockOutController::class, 'confirm'])->name('confirm');
            });

            Route::prefix('transfer')->as('transfer.')->group(function () {
                Route::get('/', [TransferController::class, 'index'])->name('index');
                Route::get('create', [TransferController::class, 'create'])->name('create');
                Route::post('/', [TransferController::class, 'store'])->name('store');
                Route::post('{id}/confirm-out', [TransferController::class, 'confirmOut'])->name('confirm-out');
                Route::post('{id}/confirm-in', [TransferController::class, 'confirmIn'])->name('confirm-in');
            });

            Route::prefix('count')->as('count.')->group(function () {
                Route::get('/', [CountController::class, 'index'])->name('index');
                Route::get('create', [CountController::class, 'create'])->name('create');
                Route::post('/', [CountController::class, 'store'])->name('store');
                Route::get('{id}/count', [CountController::class, 'count'])->name('count');
                Route::post('{id}/confirm-count', [CountController::class, 'confirmCount'])->name('confirm-count');
                Route::post('{id}/confirm-adjustment', [CountController::class, 'confirmAdjustment'])->name('confirm-adjustment');
            });

            Route::prefix('defect')->as('defect.')->group(function () {
                Route::get('/', [DefectAssessmentController::class, 'index'])->name('index');
                Route::get('create', [DefectAssessmentController::class, 'create'])->name('create');
                Route::post('/', [DefectAssessmentController::class, 'store'])->name('store');
                Route::get('{id}/assess', [DefectAssessmentController::class, 'assess'])->name('assess');
                Route::post('{id}/confirm-assess', [DefectAssessmentController::class, 'confirmAssess'])->name('confirm-assess');
                Route::post('{id}/approve', [DefectAssessmentController::class, 'approve'])->name('approve');
                Route::post('{id}/complete', [DefectAssessmentController::class, 'complete'])->name('complete');
                Route::post('{id}/reject', [DefectAssessmentController::class, 'reject'])->name('reject');
            });

            Route::prefix('returns')->as('returns.')->group(function () {
                Route::get('/', [ReturnController::class, 'index'])->name('index');
                Route::get('create', [ReturnController::class, 'create'])->name('create');
                Route::post('/', [ReturnController::class, 'store'])->name('store');
                Route::get('{id}', [ReturnController::class, 'show'])->name('show')->where('id', '[0-9]+');
                Route::post('{id}/approve', [ReturnController::class, 'approve'])->name('approve')->where('id', '[0-9]+');
                Route::post('{id}/reject', [ReturnController::class, 'reject'])->name('reject')->where('id', '[0-9]+');
                Route::post('{id}/confirm-received', [ReturnController::class, 'confirmReceived'])->name('confirmReceived')->where('id', '[0-9]+');
                Route::post('{id}/qc', [ReturnController::class, 'qc'])->name('qc')->where('id', '[0-9]+');
                Route::post('{id}/complete', [ReturnController::class, 'complete'])->name('complete')->where('id', '[0-9]+');
            });

            Route::prefix('stock-out-invoice')->as('stock-out-invoice.')->group(function () {
                Route::get('/', [StockOutInvoiceController::class, 'index'])->name('index');
                Route::get('{id}', [StockOutInvoiceController::class, 'show'])->name('show')->where('id', '[0-9]+');
                Route::post('{id}/complete', [StockOutInvoiceController::class, 'complete'])->name('complete')->where('id', '[0-9]+');
            });

            Route::prefix('warehouses')->as('warehouses.')->group(function () {
                Route::get('/', [WarehouseController::class, 'index'])->name('index');
                Route::get('create', [WarehouseController::class, 'create'])->name('create');
                Route::post('/', [WarehouseController::class, 'store'])->name('store');
                Route::get('{warehouse}', [WarehouseController::class, 'show'])->name('show');
                Route::get('{warehouse}/edit', [WarehouseController::class, 'edit'])->name('edit');
                Route::put('{warehouse}', [WarehouseController::class, 'update'])->name('update');
                Route::delete('{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');
            });

            Route::get('reports', [InventoryController::class, 'reports'])->name('reports');
            Route::get('current-stock', [InventoryController::class, 'currentStock'])->name('current-stock');
        });

        Route::prefix('notifications')->as('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-read');
            Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        });
    });
});
