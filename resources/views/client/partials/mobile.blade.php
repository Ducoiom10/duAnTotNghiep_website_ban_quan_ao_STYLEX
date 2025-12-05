		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<!-- Logo desktop -->		
					<a href="{{ route('home') }}" class="logo">
					STYLE<span>X</span>
					</a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
		<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
			<i class="zmdi zmdi-search"></i>
		</div>

		@php
			if (\Illuminate\Support\Facades\Auth::check()) {
				$cartCountMobile = \App\Models\Cart::where('user_id', \Illuminate\Support\Facades\Auth::id())->sum('quantity');
				$sessionItems = session('cart.items', []);
				foreach ($sessionItems as $it) { $cartCountMobile += (int)($it['quantity'] ?? 0); }
			} else {
				$sessionItems = session('cart.items', []);
				$cartCountMobile = 0;
				foreach ($sessionItems as $it) { $cartCountMobile += (int)($it['quantity'] ?? 0); }
			}
		@endphp
		<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="{{ $cartCountMobile }}">
			<i class="zmdi zmdi-shopping-cart"></i>
		</div>
			
		<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
			<i class="zmdi zmdi-favorite-outline"></i>
		</a>
											
					<a href="login.html" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
						<i class="zmdi zmdi-account"></i>
					</a>
			
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							EN
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							USD
						</a>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.html">Home</a>
					<ul class="sub-menu-m">
						<li><a href="index.html">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product.html">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.html">Blog</a>
				</li>

				<li>
					<a href="about.html">About</a>
				</li>

				<li>
					<a href="contact.html">Contact</a>
				</li>
			</ul>
		</div>
