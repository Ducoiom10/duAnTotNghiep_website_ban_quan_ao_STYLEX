@extends('client.layouts.app')

@section('title', 'Sản Phẩm - ' . env('APP_NAME'))

@section('content')
<!-- Product -->
<div class="bg0 m-t-23 p-b-140"
	 id="product-page"
	 data-api-url="{{ url('/api/products/filter') }}"
	 data-index-url="{{ route('client.products.index') }}"
	 data-initial-category="{{ $selectedCategory ?? '' }}"
	 data-per-page="12"
>
	<div class="container">
		<div class="flex-w flex-sb-m p-b-52">
			<div class="flex-w flex-l-m filter-tope-group m-tb-10">
				<a href="{{ route('client.products.index') }}"
				   class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ !request('category') ? 'how-active1' : '' }} category-filter-link"
				   data-filter="*"
				   data-category-id=""
				>
					Tất Cả Sản Phẩm
				</a>

				@if(isset($categories) && $categories->count() > 0)
					@foreach($categories as $category)
						<div class="category-menu-item" style="position: relative; display: inline-block;">
							<a href="{{ route('client.products.index', ['category' => $category->id]) }}"
							   class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ request('category') == $category->id || (request('category') && in_array(request('category'), $category->children->pluck('id')->toArray())) ? 'how-active1' : '' }} category-filter-link"
							   data-filter=".category-{{ $category->id }}"
							   data-category-id="{{ $category->id }}"
							>
								{{ $category->name }}
								@if($category->children && $category->children->count() > 0)
									<i class="zmdi zmdi-chevron-down" style="font-size: 14px; margin-left: 4px;"></i>
								@endif
							</a>
							
							@if($category->children && $category->children->count() > 0)
								<div class="category-submenu" style="position: absolute; top: 100%; left: 0; background: #fff; border: 1px solid #e6e6e6; border-radius: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1); min-width: 200px; z-index: 100; display: none; margin-top: 0; padding: 5px 0;">
									@foreach($category->children as $child)
										<a href="{{ route('client.products.index', ['category' => $child->id]) }}"
										   class="submenu-item stext-106 cl6 hov1 bor3 trans-04 {{ request('category') == $child->id ? 'how-active1' : '' }} category-filter-link"
										   data-category-id="{{ $child->id }}"
										   style="display: block; padding: 8px 20px; margin: 0 10px; border-bottom: 1px solid #f0f0f0;"
										>
											{{ $child->name }}
										</a>
									@endforeach
								</div>
							@endif
						</div>
					@endforeach
				@endif
			</div>
			
			<style>
				.category-menu-item {
					position: relative;
					display: inline-block;
				}
				.category-menu-item:hover .category-submenu {
					display: block !important;
				}
				.category-submenu:hover {
					display: block !important;
				}
				.submenu-item {
					text-decoration: none;
				}
				.submenu-item:hover,
				.submenu-item.how-active1 {
					color: #333 !important;
					border-color: #797979 !important;
				}
				.category-submenu .submenu-item:last-child {
					border-bottom: none !important;
				}
				.category-submenu .submenu-item {
					border-bottom-width: 1px;
					border-bottom-style: solid;
				}
				.product-price {
					display: inline-flex;
					align-items: center;
					gap: 6px;
					flex-wrap: wrap;
				}
				.product-price .sale-price {
					font-weight: 600;
					color: #111;
				}
				.product-price .original-price {
					text-decoration: line-through;
					color: #dc3545;
					font-size: 0.95rem;
				}
			</style>

			<div class="flex-w flex-c-m m-tb-10">
				<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
					<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
					<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
					 Lọc
				</div>

				<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
					<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
					<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
					Tìm Kiếm
				</div>
			</div>
			
			<!-- Search product -->
			<div class="dis-none panel-search w-full p-t-10 p-b-15">
				<div class="bor8 dis-flex p-l-15">
					<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>

					<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" id="product-search-input" placeholder="Tìm kiếm sản phẩm..." value="{{ request('keyword') }}">
				</div>	
			</div>

			@include('client.partials.filter-product')
		</div>

		<div class="row" id="product-grid">
			<div class="col-12 text-center text-muted py-5" id="product-grid-empty">
				Đang tải sản phẩm...
			</div>
		</div>
		<div id="product-pagination" class="mt-4"></div>
	</div>
</div>

@include('client.products.mini-product')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
	const pageEl = document.getElementById('product-page');
	if (!pageEl) return;

	const config = {
		apiUrl: pageEl.dataset.apiUrl,
		indexUrl: pageEl.dataset.indexUrl,
		perPage: parseInt(pageEl.dataset.perPage, 10) || 12,
		initialCategory: pageEl.dataset.initialCategory ? Number(pageEl.dataset.initialCategory) : null,
		defaultImage: "{{ asset('client/images/product/product-01.jpg') }}",
		detailBaseUrl: "{{ url('/products') }}"
	};

	const state = {
		categoryId: config.initialCategory,
		keyword: '',
		sort: 'relevance',
		minPrice: null,
		maxPrice: null,
		textureId: null,
		page: 1,
		perPage: config.perPage,
		isLoading: false
	};

	const $grid = $('#product-grid');
	const $pagination = $('#product-pagination');
	const $searchInput = $('#product-search-input');
	state.keyword = $searchInput.val() || '';

	function escapeHtml(value) {
		if (value === null || value === undefined) return '';
		return String(value)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#039;');
	}

	function formatCurrency(value) {
		const number = Number(value) || 0;
		return new Intl.NumberFormat('vi-VN').format(number) + ' ₫';
	}

	function buildParams() {
		const params = {
			page: state.page,
			per_page: state.perPage,
			sort: state.sort
		};

		if (state.keyword?.trim()) {
			params.keyword = state.keyword.trim();
		}
		if (state.categoryId) {
			params.category_id = state.categoryId;
		}
		if (state.minPrice !== null && state.minPrice !== '') {
			params.min_price = state.minPrice;
		}
		if (state.maxPrice !== null && state.maxPrice !== '') {
			params.max_price = state.maxPrice;
		}
		if (state.textureId) {
			params.texture_id = state.textureId;
		}

		return params;
	}

	function renderProducts(items) {
		if (!items || !items.length) {
			$grid.html('<div class="col-12 text-center text-muted py-5">Không tìm thấy sản phẩm phù hợp</div>');
			return;
		}

		const cards = items.map(product => {
			const detailUrl = `${config.detailBaseUrl}/${product.id}`;
			const quickViewUrl = state.categoryId
				? `${config.indexUrl}?quick_view=${product.id}&category=${state.categoryId}`
				: `${config.indexUrl}?quick_view=${product.id}`;

			const hasSale = product.price_sale && Number(product.price_sale) < Number(product.price);
			let priceHtml = `<span class="stext-105 cl3 product-price">`;
			if (hasSale) {
				priceHtml += `
					<span class="sale-price">${formatCurrency(product.price_sale)}</span>
					<span class="original-price">${formatCurrency(product.price)}</span>
				`;
			} else {
				priceHtml += formatCurrency(product.price);
			}
			priceHtml += `</span>`;

			const imageUrl = product.default_image_url || product.default_image || config.defaultImage;

			return `
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35">
					<div class="block2">
						<div class="block2-pic hov-img0">
							<img src="${imageUrl}" alt="${escapeHtml(product.name ?? '')}">
							<a href="${quickViewUrl}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                Xem nhanh
                            </a>
						</div>
						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l">
								<a href="${detailUrl}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									${escapeHtml(product.name ?? '')}
								</a>
								${priceHtml}
							</div>
							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
									<img class="icon-heart1 dis-block trans-04" src="{{ asset('client/images/icons/icon-heart-01.png') }}" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('client/images/icons/icon-heart-02.png') }}" alt="ICON">
								</a>
							</div>
						</div>
					</div>
				</div>
			`;
		}).join('');

		$grid.html(cards);
	}

	function renderPagination(meta) {
		if (!meta || meta.last_page <= 1) {
			$pagination.empty();
			return;
		}

		let html = '<nav><ul class="pagination justify-content-center">';
		const start = Math.max(1, meta.current_page - 2);
		const end = Math.min(meta.last_page, meta.current_page + 2);

		for (let page = start; page <= end; page++) {
			const active = page === meta.current_page ? ' active' : '';
			html += `<li class="page-item${active}">
				<a class="page-link product-pagination-link" href="#" data-page="${page}">${page}</a>
			</li>`;
		}

		html += '</ul></nav>';

		$pagination.html(html);
	}

	function setActiveCategory(categoryId) {
		$('.category-filter-link').removeClass('how-active1');
		if (!categoryId) {
			$('.category-filter-link[data-category-id=""]').addClass('how-active1');
		} else {
			$(`.category-filter-link[data-category-id="${categoryId}"]`).addClass('how-active1');
		}
	}

	function setActiveSort(sort) {
		$('.js-sort-filter').removeClass('filter-link-active');
		$(`.js-sort-filter[data-sort="${sort}"]`).addClass('filter-link-active');
	}

	function setActivePrice(min, max) {
		$('.js-price-filter').removeClass('filter-link-active');
		const selector = `.js-price-filter[data-min="${min ?? ''}"][data-max="${max ?? ''}"]`;
		const $target = $(selector);
		if ($target.length) {
			$target.addClass('filter-link-active');
		}
	}

	function setActiveTexture(textureId) {
		$('.js-texture-filter').removeClass('filter-link-active');
		const id = textureId ?? '';
		const selector = `.js-texture-filter[data-texture-id="${id}"]`;
		const $target = $(selector);
		if ($target.length) {
			$target.addClass('filter-link-active');
		}
	}

	function updateUrl() {
		const url = new URL(window.location.href);
		if (state.categoryId) {
			url.searchParams.set('category', state.categoryId);
		} else {
			url.searchParams.delete('category');
		}
		if (state.keyword) {
			url.searchParams.set('keyword', state.keyword);
		} else {
			url.searchParams.delete('keyword');
		}
		window.history.replaceState({}, '', url);
	}

	function fetchProducts() {
		if (state.isLoading) return;
		state.isLoading = true;
		$grid.html('<div class="col-12 text-center py-5"><span class="spinner-border text-dark" role="status"></span></div>');

		$.ajax({
			url: config.apiUrl,
			type: 'GET',
			data: buildParams(),
			success(response) {
				renderProducts(response.data || []);
				renderPagination(response.meta || null);
				updateUrl();
			},
			error(xhr) {
				$grid.html('<div class="col-12 text-center text-danger py-5">Không thể tải sản phẩm. Vui lòng thử lại sau.</div>');
				if (typeof showToast === 'function') {
					showToast('Không thể tải sản phẩm.', 'error');
				}
			},
			complete() {
				state.isLoading = false;
			}
		});
	}

	$(document).on('click', '.category-filter-link', function(e) {
		e.preventDefault();
		const categoryId = $(this).data('category-id');
		state.categoryId = categoryId ? Number(categoryId) : null;
		state.page = 1;
		setActiveCategory(categoryId || '');
		fetchProducts();
	});

	$(document).on('click', '.js-sort-filter', function(e) {
		e.preventDefault();
		const sortValue = $(this).data('sort');
		if (!sortValue) return;
		state.sort = sortValue;
		state.page = 1;
		setActiveSort(sortValue);
		fetchProducts();
	});

	$(document).on('click', '.js-price-filter', function(e) {
		e.preventDefault();
		const min = $(this).data('min');
		const max = $(this).data('max');
		state.minPrice = min !== undefined && min !== '' ? Number(min) : null;
		state.maxPrice = max !== undefined && max !== '' ? Number(max) : null;
		state.page = 1;
		setActivePrice($(this).data('min') ?? '', $(this).data('max') ?? '');
		fetchProducts();
	});

	$(document).on('click', '.js-texture-filter', function(e) {
		e.preventDefault();
		const textureId = $(this).data('texture-id');
		state.textureId = textureId ? Number(textureId) : null;
		state.page = 1;
		setActiveTexture(textureId || '');
		fetchProducts();
	});

	$(document).on('click', '.product-pagination-link', function(e) {
		e.preventDefault();
		const targetPage = Number($(this).data('page'));
		if (!targetPage || targetPage === state.page || targetPage < 1) return;
		state.page = targetPage;
		fetchProducts();
	});

	let searchTimeout = null;
	$searchInput.on('input', function() {
		const value = $(this).val();
		clearTimeout(searchTimeout);
		searchTimeout = setTimeout(() => {
			state.keyword = value;
			state.page = 1;
			fetchProducts();
		}, 400);
	});

	// init UI state
	setActiveCategory(state.categoryId || '');
	setActiveSort(state.sort);
	setActivePrice('', '');
	setActiveTexture('');

	fetchProducts();
});
</script>
@endpush
