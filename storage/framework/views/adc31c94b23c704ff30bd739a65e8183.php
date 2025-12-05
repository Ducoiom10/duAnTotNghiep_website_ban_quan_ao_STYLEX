		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
					Khi mua đơn hàng 200k sẽ được free ship 
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Trợ giúp & FAQs
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Tài Khoản
						</a>

					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop how-shadow1">
				<nav class="limiter-menu-desktop container">
						
					<!-- Logo desktop -->		
					<a href="<?php echo e(route('home')); ?>" class="logo">
					STYLE<span>X</span>
					</a>

					<!-- Menu desktop -->
                   					<div class="menu-desktop">
					    <ul class="main-menu">
					        <li class="<?php echo e(request()->routeIs('home') ? 'active-menu' : ''); ?>">
					            <a href="<?php echo e(route('home')); ?>">Trang Chủ</a>
					        </li>

					        <li class="<?php echo e(request()->routeIs('client.products.*') ? 'active-menu' : ''); ?>">
					            <a href="<?php echo e(route('client.products.index')); ?>">Sản Phẩm</a>
					        </li>

					        <li class="label1 <?php echo e(request()->is('shoping-cart') ? 'active-menu' : ''); ?>" data-label1="hot">
					            <a href="shoping-cart.html">Sắp Ra Mắt</a>
					        </li>

					        <li class="<?php echo e(request()->is('blog') ? 'active-menu' : ''); ?>">
					            <a href="<?php echo e(route('blog.index')); ?>">Blog</a>
					        </li>

					        <li class="<?php echo e(request()->is('contact') ? 'active-menu' : ''); ?>">
					            <a href="contact.html">Liên Hệ</a>
					        </li>
					    </ul>
					</div>
                    
					<!-- Icon header -->
					<?php
						if (\Illuminate\Support\Facades\Auth::check()) {
							$cartCount = \App\Models\Cart::where('user_id', \Illuminate\Support\Facades\Auth::id())->sum('quantity');
							// include session items if any left from guest
							$sessionItems = session('cart.items', []);
							foreach ($sessionItems as $it) { $cartCount += (int)($it['quantity'] ?? 0); }
						} else {
							$sessionItems = session('cart.items', []);
							$cartCount = 0;
							foreach ($sessionItems as $it) { $cartCount += (int)($it['quantity'] ?? 0); }
						}
					?>
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?php echo e($cartCount); ?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="#" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
						
						<?php if(auth()->guard()->check()): ?>
							<?php $authUser = Auth::user(); ?>
							<!-- User đã đăng nhập -->
							<div class="dropdown">
								<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 dropdown-toggle" data-bs-toggle="dropdown">
									<i class="zmdi zmdi-account"></i>
									<span class="ml-2"><?php echo e($authUser->name ?? ''); ?></span>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<div class="dropdown-header">
										<div class="user-info">
											<div class="user-name"><?php echo e($authUser->name ?? ''); ?></div>
											<div class="user-email"><?php echo e($authUser->email ?? ''); ?></div>
										</div>
									</div>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">
										<i class="zmdi zmdi-account-circle me-2"></i>
										Hồ sơ cá nhân
									</a>
									<a class="dropdown-item" href="<?php echo e(route('client.order.list')); ?>">
										<i class="zmdi zmdi-shopping-cart me-2"></i>
										Đơn hàng của tôi
									</a>
									<a class="dropdown-item" href="#">
										<i class="zmdi zmdi-favorite me-2"></i>
										Yêu thích
									</a>
									<a class="dropdown-item" href="#">
										<i class="zmdi zmdi-settings me-2"></i>
										Cài đặt
									</a>
									<div class="dropdown-divider"></div>
									<form method="POST" action="<?php echo e(route('logout')); ?>">
										<?php echo csrf_field(); ?>
										<button type="submit" class="dropdown-item logout-btn">
											<i class="zmdi zmdi-power me-2"></i>
											Đăng xuất
										</button>
									</form>
								</div>
							</div>
						<?php else: ?>
							<!-- User chưa đăng nhập -->
							<a href="<?php echo e(route('loginView')); ?>" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
								<i class="zmdi zmdi-account"></i>
							</a>
						<?php endif; ?>
					</div>
				</nav>
			</div>	
		</div>

		 <!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="<?php echo e(asset('client/images/icons/icon-close2.png')); ?>" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\partials\sidebar.blade.php ENDPATH**/ ?>