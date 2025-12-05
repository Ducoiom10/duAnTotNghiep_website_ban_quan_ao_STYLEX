@extends('client.layouts.app')

@section('title', $product->name . ' - ' . env('APP_NAME'))

@push('styles')
<style>
    .product-image {
        width: 100%;
        height: auto;
        max-width: 100%;
        object-fit: contain;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        -ms-interpolation-mode: nearest-neighbor;
    }
    
    .wrap-pic-w img {
        width: 100% !important;
        height: auto !important;
        max-width: 100% !important;
        object-fit: contain !important;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        -ms-interpolation-mode: nearest-neighbor;
    }
</style>
@endpush

@section('content')

	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
				Trang Chủ
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="{{ route('client.products.index') }}" class="stext-109 cl8 hov-cl1 trans-04">
				Sản Phẩm
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				{{ $product->name }}
			</span>
		</div>
	</div>

	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
								@if($product->productImages && $product->productImages->count() > 0)
									@foreach($product->productImages as $image)
									@php
										// Helper để lấy URL ảnh
										$imageUrl = $image->image_path;
										if (str_starts_with($imageUrl, 'client/images/')) {
											$imageUrl = asset($imageUrl);
										} else {
											$imageUrl = Storage::url($imageUrl);
										}
									@endphp
									<div class="item-slick3" data-thumb="{{ $imageUrl }}">
										<div class="wrap-pic-w pos-relative">
											<img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="product-image">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ $imageUrl }}">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
									@endforeach
								@else
									<div class="item-slick3" data-thumb="{{ $product->default_image_url }}">
										<div class="wrap-pic-w pos-relative">
											<img src="{{ $product->default_image_url }}" alt="{{ $product->name }}" class="product-image">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ $product->default_image_url }}">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							{{ $product->name }}
						</h4>

						<span class="mtext-106 cl2">
							@if($product->price_sale && $product->price_sale < $product->price)
								<span class="fw-bold">{{ number_format($product->price_sale, 0, ',', '.') }}đ</span>
								<span style="text-decoration: line-through; color: red; margin-left: 8px;">
									{{ number_format($product->price, 0, ',', '.') }}đ
								</span>
							@else
								{{ number_format($product->price, 0, ',', '.') }}đ
							@endif
						</span>

						<p class="stext-102 cl3 p-t-23">
							{{ $product->description ?? 'Sản phẩm chất lượng cao với thiết kế hiện đại và phong cách độc đáo.' }}
						</p>
						
						<!-- Product Options -->
						<div class="p-t-33">
							@if($product->productVariants && $product->productVariants->count() > 0)
								@php
									// Lấy variant đầu tiên làm mặc định
									$firstVariant = $product->productVariants->first();
									$defaultSize = $firstVariant->size ? $firstVariant->size->name : '';
									$defaultColor = $firstVariant->color ? $firstVariant->color->name : '';
									$defaultTexture = $firstVariant->texture ? $firstVariant->texture->name : '';
									$defaultVariantId = $firstVariant->id;
									
									$sizes = $product->productVariants->pluck('size.name')->unique()->filter();
									$colors = $product->productVariants->pluck('color.name')->unique()->filter();
									$textures = $product->productVariants->pluck('texture.name')->unique()->filter();
									
									// Tạo map variant_id => variant data để JavaScript dùng
									$variantsMap = $product->productVariants->mapWithKeys(function($variant) {
										$key = '';
										$parts = [];
										if ($variant->size) $parts[] = 'size:' . $variant->size->name;
										if ($variant->color) $parts[] = 'color:' . $variant->color->name;
										if ($variant->texture) $parts[] = 'texture:' . $variant->texture->name;
										$key = implode('|', $parts);
										return [$key => [
											'id' => $variant->id,
											'price' => $variant->price,
										]];
									})->toArray();
								@endphp
								
								@if($sizes->count() > 0)
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Kích Thước
									</div>

									<div class="size-204 respon6-next">
										<div class="flex-w flex-l-m" id="size-buttons-container" style="flex-wrap: wrap; gap: 8px;">
											@foreach($sizes as $size)
											@php
												$isSelected = $size == $defaultSize;
												$btnStyle = $isSelected 
													? 'min-width: 60px; padding: 8px 12px; border-radius: 4px; cursor: pointer; transition: all 0.3s; background-color: #333; color: #fff; border-color: #333;'
													: 'min-width: 60px; padding: 8px 12px; border-radius: 4px; cursor: pointer; transition: all 0.3s; background-color: #f5f5f5; color: #666; border-color: #e0e0e0;';
											@endphp
											<button type="button" 
													class="size-variant-btn stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04" 
													data-size="{{ $size }}"
													style="{{ $btnStyle }}"
													title="{{ $size }}">
												{{ $size }}
											</button>
											@endforeach
										</div>
										<!-- Hidden input để lưu size đã chọn -->
										<input type="hidden" name="size" id="size-select" value="{{ $defaultSize }}">
									</div>
								</div>
								@endif

								@if($colors->count() > 0)
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Màu Sắc
									</div>

									<div class="size-204 respon6-next">
										<div class="flex-w flex-l-m" id="color-buttons-container" style="flex-wrap: wrap; gap: 8px;">
											@foreach($colors as $color)
											@php
												$isSelected = $color == $defaultColor;
												// Dùng style giống nút kích thước để màu sắc nhìn đồng bộ
												$btnStyle = $isSelected 
													? 'min-width: 60px; padding: 8px 12px; border-radius: 4px; cursor: pointer; transition: all 0.3s; background-color: #333; color: #fff; border-color: #333;'
													: 'min-width: 60px; padding: 8px 12px; border-radius: 4px; cursor: pointer; transition: all 0.3s; background-color: #f5f5f5; color: #666; border-color: #e0e0e0;';
											@endphp
											<button type="button" 
													class="color-variant-btn stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04" 
													data-color="{{ $color }}"
													style="{{ $btnStyle }}"
													title="{{ $color }}">
												{{ $color }}
											</button>
											@endforeach
										</div>
										<!-- Hidden input để lưu màu đã chọn -->
										<input type="hidden" name="color" id="color-select" value="{{ $defaultColor }}">
									</div>
								</div>
								@endif

								@if($textures->count() > 0)
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Chất Liệu
									</div>

									<div class="size-204 respon6-next">
										<div class="stext-102 cl6" style="padding: 8px 0;">
											<span id="texture-display">{{ $textures->implode(', ') }}</span>
											<input type="hidden" name="texture" id="texture-select" value="{{ $defaultTexture }}">
										</div>
									</div>
								</div>
								@endif

							@endif

							@php
								// Tạo map variant để JavaScript tìm variant_id nhanh
								$variantsData = $product->productVariants->map(function($variant) {
									return [
										'id' => $variant->id,
										'price' => $variant->price,
										'size' => $variant->size ? $variant->size->name : '',
										'color' => $variant->color ? $variant->color->name : '',
										'texture' => $variant->texture ? $variant->texture->name : '',
									];
								})->toArray();
							@endphp
							<div class="flex-w flex-r-m p-b-10" 
								 data-product-id="{{ $product->id }}"
								 data-original-price="{{ $product->price }}"
								 data-original-price-sale="{{ $product->price_sale }}">
                              <script type="application/json" id="variants-data">
								{!! json_encode($variantsData) !!}
                              </script>
                              <form id="add-to-cart-form" method="POST" action="{{ route('client.cart.add') }}" data-ajax="1" class="size-204 flex-w flex-m respon6-next">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="variant_id" value="{{ isset($defaultVariantId) ? $defaultVariantId : '' }}">
                                    <input type="hidden" name="size_name" value="{{ isset($defaultSize) ? $defaultSize : '' }}">
                                    <input type="hidden" name="color_name" value="{{ isset($defaultColor) ? $defaultColor : '' }}">
                                    <input type="hidden" name="texture_name" value="{{ isset($defaultTexture) ? $defaultTexture : '' }}">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="quantity" value="1" min="1">

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>

                                    <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
										Thêm vào giỏ
									</button>
                                </form>
							</div>	
						</div>

						<!-- Social Share -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Thêm vào yêu thích">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="bor10 m-t-50 p-t-43 p-b-40">
				<!-- Tab01 -->
				<div class="tab01">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item p-b-10">
							<a class="nav-link active" data-toggle="tab" href="#description" role="tab">Mô tả</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#information" role="tab">Thông tin bổ sung</a>
						</li>

						<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#reviews" role="tab">
								Đánh giá 
								({{ $product->reviews()->where('status', 'public')->count() }})
							</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content p-t-43">
						<!-- Description -->
						<div class="tab-pane fade show active" id="description" role="tabpanel">
							<div class="how-pos2 p-lr-15-md">
								<p class="stext-102 cl6">
									{{ $product->description ?? 'Sản phẩm chất lượng cao với thiết kế hiện đại và phong cách độc đáo. Được làm từ những nguyên liệu tốt nhất, đảm bảo độ bền và tính thẩm mỹ cao.' }}
								</p>
							</div>
						</div>

						<!-- Additional Information -->
						<div class="tab-pane fade" id="information" role="tabpanel">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
									<ul class="p-lr-28 p-lr-15-sm">
										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Danh mục
											</span>

											<span class="stext-102 cl6 size-206">
												{{ $product->category->name ?? 'N/A' }}
											</span>
										</li>

										<li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Trạng thái
											</span>

											<span class="stext-102 cl6 size-206">
												{{ $product->is_active ? 'Còn hàng' : 'Hết hàng' }}
											</span>
										</li>

										@if($product->productVariants && $product->productVariants->count() > 0)
											@php
												$sizes = $product->productVariants->pluck('size.name')->unique()->filter();
												$colors = $product->productVariants->pluck('color.name')->unique()->filter();
											@endphp
											
											@if($colors->count() > 0)
											<li class="flex-w flex-t p-b-7">
												<span class="stext-102 cl3 size-205">
													Màu sắc
												</span>

												<span class="stext-102 cl6 size-206">
													{{ $colors->implode(', ') }}
												</span>
											</li>
											@endif

											@if($sizes->count() > 0)
											<li class="flex-w flex-t p-b-7">
												<span class="stext-102 cl3 size-205">
													Kích thước
												</span>

												<span class="stext-102 cl6 size-206">
													{{ $sizes->implode(', ') }}
												</span>
											</li>
											@endif
										@endif
									</ul>
								</div>
							</div>
						</div>

						<!-- Reviews -->
						<div class="tab-pane fade" id="reviews" role="tabpanel">
							<div class="how-pos2 p-lr-15-md">
								@php
									$fullStars = floor($avgRating ?? 0);
									$hasHalfStar = ($avgRating ?? 0) - $fullStars >= 0.5;
									$reviewsCount = $product->reviews()->where('status', 'public')->count();
								@endphp
								
								<!-- Tổng quan đánh giá -->
								@if($reviewsCount > 0)
									<div class="p-b-30 bor12">
										<div class="flex-w flex-m p-b-20 p-t-20">
											<div class="p-r-30">
												<div class="mtext-102 cl2 p-b-5">
													Đánh giá trung bình
												</div>
												<div class="mtext-105 cl2 p-b-10">
													{{ number_format($avgRating ?? 0, 1) }}<span class="stext-102 cl6">/5</span>
												</div>
												<div class="flex-w flex-m p-b-10">
													@for ($i = 1; $i <= 5; $i++)
														@if ($i <= $fullStars)
															<i class="fa fa-star cl2" style="font-size:20px;color:#ffc107;"></i>
														@elseif ($i == $fullStars + 1 && $hasHalfStar)
															<i class="fa fa-star-half-o cl2" style="font-size:20px;color:#ffc107;"></i>
														@else
															<i class="fa fa-star-o cl6" style="font-size:20px;"></i>
														@endif
													@endfor
												</div>
												<p class="stext-102 cl6">
													Dựa trên {{ $reviewsCount }} đánh giá
												</p>
											</div>
										</div>
									</div>
								@endif

								<!-- Danh sách đánh giá -->
								@if($latestReviews && $latestReviews->count() > 0)
									<div class="p-t-10">
										@foreach ($latestReviews as $review)
											<div class="flex-w flex-t p-b-20 bor12 p-t-20">
												<div class="size-209 p-r-20">
													<div class="flex-c-m size-108 how-pos1 bor0" style="width:60px;height:60px;border-radius:50%;background:#e6e6e6;color:#333;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:24px;">
														@if ($review['user']['avatar'])
															<img src="{{ $review['user']['avatar'] }}"
																alt="{{ $review['user']['name'] }}"
																style="width:60px;height:60px;border-radius:50%;object-fit:cover;">
														@else
															{{ strtoupper(substr($review['user']['name'], 0, 1)) }}
														@endif
													</div>
												</div>
												<div class="size-207">
													<div class="flex-w flex-sb-m p-b-10">
														<span class="stext-102 cl3 m-r-20" style="font-weight:600;">
															{{ $review['user']['name'] }}
														</span>
														<span class="stext-102 cl6">
															{{ $review['created_at'] }}
														</span>
													</div>
													<div class="flex-w flex-m p-b-10">
														@for ($i = 1; $i <= 5; $i++)
															@if ($i <= $review['rating'])
																<i class="fa fa-star cl2" style="font-size:16px;color:#ffc107;"></i>
															@else
																<i class="fa fa-star-o cl6" style="font-size:16px;"></i>
															@endif
														@endfor
													</div>
													@if($review['variant'])
														<p class="stext-102 cl6 p-b-10">
															<strong>Phân loại hàng:</strong> {{ $review['variant'] }}
														</p>
													@endif
													@if (!empty($review['comment']))
														<p class="stext-102 cl6 p-b-10" style="line-height:1.8;">
															{{ $review['comment'] }}
														</p>
													@endif
													@if (!empty($review['tags']))
														<div class="p-b-10">
															@foreach ($review['tags'] as $tag)
																<span class="stext-102 cl6" style="background:#f5f5f5;padding:4px 10px;border-radius:3px;margin-right:8px;display:inline-block;margin-bottom:4px;">
																	{{ $tag }}
																</span>
															@endforeach
														</div>
													@endif
													@if (!empty($review['media']))
														<div class="flex-w flex-m p-t-10">
															@foreach ($review['media'] as $mediaUrl)
																<div class="p-r-10">
																	<img src="{{ $mediaUrl }}"
																		alt="Ảnh đánh giá"
																		class="hov-img0"
																		style="width:80px;height:80px;object-fit:cover;border-radius:4px;cursor:pointer;border:1px solid #e6e6e6;"
																		onclick="window.open('{{ $mediaUrl }}', '_blank')">
																</div>
															@endforeach
														</div>
													@endif
												</div>
											</div>
										@endforeach
									</div>
								@else
									<div class="p-t-20 p-b-20">
										<p class="stext-102 cl6 text-center">
											Chưa có đánh giá nào cho sản phẩm này.
										</p>
									</div>
								@endif
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>

			<div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
				<span class="stext-107 cl6 p-lr-25">
					SKU: {{ $product->id }}
				</span>

				<span class="stext-107 cl6 p-lr-25">
					Danh mục: {{ $product->category->name ?? 'N/A' }}
				</span>
			</div>
		</div>
	</section>

	<!-- Related Products -->
	@if($relatedProducts && $relatedProducts->count() > 0)
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<div class="p-b-45">
				<h3 class="ltext-106 cl5 txt-center">
					Sản Phẩm Liên Quan
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
					@foreach($relatedProducts as $relatedProduct)
					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="{{ $relatedProduct->default_image_url }}" alt="{{ $relatedProduct->name }}">

								<a href="{{ route('client.products.show', $relatedProduct->id) }}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
									Xem Chi Tiết
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="{{ route('client.products.show', $relatedProduct->id) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										{{ $relatedProduct->name }}
									</a>

									<span class="stext-105 cl3">
										@if($relatedProduct->price_sale && $relatedProduct->price_sale < $relatedProduct->price)
											<span class="fw-bold">{{ number_format($relatedProduct->price_sale, 0, ',', '.') }}đ</span>
											<span style="text-decoration: line-through; color: red;">{{ number_format($relatedProduct->price, 0, ',', '.') }}đ</span>
										@else
											{{ number_format($relatedProduct->price, 0, ',', '.') }}đ
										@endif
									</span>
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
					@endforeach
				</div>
			</div>
		</div>
	</section>
	@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Lấy dữ liệu variants từ script tag
    let variants = [];
    try {
        const variantsScript = $('#variants-data');
        if (variantsScript.length) {
            const variantsText = variantsScript.text().trim();
            if (variantsText) {
                variants = JSON.parse(variantsText);
                if (!Array.isArray(variants)) {
                    variants = [];
                }
            }
        }
    } catch(e) {
        variants = [];
    }
    
    // Lấy giá từ data attributes
    const productContainer = $('[data-product-id]');
    const originalPrice = parseFloat(productContainer.attr('data-original-price') || 0);
    const originalPriceSale = parseFloat(productContainer.attr('data-original-price-sale') || 0);
    const hasPriceSale = originalPriceSale && originalPriceSale < originalPrice;
    
    // Function đơn giản để tìm variant dựa trên size, color, texture
    function findVariant(size, color, texture) {
        size = (size || '').toString().trim();
        color = (color || '').toString().trim();
        texture = (texture || '').toString().trim();
        
        return variants.find(variant => {
            const vSize = (variant.size || '').toString().trim();
            const vColor = (variant.color || '').toString().trim();
            const vTexture = (variant.texture || '').toString().trim();
            
            // Phải khớp chính xác tất cả các thuộc tính được chọn
            const matchSize = !size || vSize === size;
            const matchColor = !color || vColor === color;
            const matchTexture = !texture || vTexture === texture;
            
            return matchSize && matchColor && matchTexture;
        });
    }
    
    // Function để lọc và hiển thị các button màu dựa trên size đã chọn
    function filterColorButtons() {
        let currentSize = '';
        
        // Lấy giá trị size từ hidden input (không còn là select2 nữa)
        if ($('#size-select').length) {
            currentSize = ($('#size-select').val() || '').trim();
        }
        
        // Lấy màu hiện tại
        let currentColor = ($('#color-select').val() || '').trim();
        
        // Lọc màu dựa trên size đã chọn
        let availableColors = [];
        if (currentSize) {
            variants.forEach(function(v) {
                const vSize = (v.size || '').toString().trim();
                const vColor = (v.color || '').toString().trim();
                if (vSize === currentSize && vColor && availableColors.indexOf(vColor) === -1) {
                    availableColors.push(vColor);
                }
            });
        } else {
            // Nếu chưa chọn size, hiển thị tất cả màu
            variants.forEach(function(v) {
                const vColor = (v.color || '').toString().trim();
                if (vColor && availableColors.indexOf(vColor) === -1) {
                    availableColors.push(vColor);
                }
            });
        }
        
        // Cập nhật các button màu
        let $colorButtonsContainer = $('#color-buttons-container');
        if ($colorButtonsContainer.length) {
            $colorButtonsContainer.empty();
            
            // Nếu không có màu khả dụng, clear input và thoát
            if (availableColors.length === 0) {
                $('#color-select').val('');
                return;
            }

            // Nếu màu hiện tại rỗng hoặc không còn hợp lệ với size mới → chọn màu đầu tiên
            if (!currentColor || availableColors.indexOf(currentColor) === -1) {
                currentColor = availableColors[0];
            }

            // Cập nhật lại hidden input theo màu được chọn
            $('#color-select').val(currentColor);

            // Vẽ lại các nút màu, set active cho màu đang chọn
            availableColors.forEach(function(color) {
                const isSelected = color === currentColor;
                const $btn = $('<button></button>')
                    .attr('type', 'button')
                    .addClass('color-variant-btn stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04')
                    .attr('data-color', color)
                    .text(color)
                    .css({
                        // Dùng style giống nút kích thước
                        'min-width': '60px',
                        'padding': '8px 12px',
                        'border-radius': '4px',
                        'cursor': 'pointer',
                        'transition': 'all 0.3s',
                        'background-color': isSelected ? '#333' : '#f5f5f5',
                        'color': isSelected ? '#fff' : '#666',
                        'border-color': isSelected ? '#333' : '#e0e0e0'
                    });
                
                $colorButtonsContainer.append($btn);
            });
        }
    }
    
    // Function để cập nhật giá và variant_id khi chọn variant
    function updateVariant() {
        let size = '';
        let color = '';
        
        // Lấy giá trị size từ hidden input (không còn là select2 nữa)
        if ($('#size-select').length) {
            size = ($('#size-select').val() || '').trim();
        }
        
        // Lấy màu từ hidden input (không còn là select2 nữa)
        if ($('#color-select').length) {
            color = ($('#color-select').val() || '').trim();
        }
        
        // DEBUG: Log để kiểm tra
        console.log('updateVariant called - Size:', size, 'Color:', color);
        
        // Tìm variant dựa trên size và color (không cần texture vì texture sẽ lấy từ variant)
        // Thử tìm variant với texture hiện tại trước, nếu không có thì tìm bất kỳ
        let texture = $('#texture-select').val() || '';
        let variant = findVariant(size, color, texture);
        
        // Nếu không tìm thấy với texture hiện tại, thử tìm không cần texture
        if (!variant) {
            variant = variants.find(v => {
                const vSize = (v.size || '').toString().trim();
                const vColor = (v.color || '').toString().trim();
                const matchSize = !size || vSize === size;
                const matchColor = !color || vColor === color;
                return matchSize && matchColor;
            });
        }
        
        // Lấy tất cả các chất liệu unique từ variants
        let allTextures = [];
        variants.forEach(function(v) {
            const vTexture = (v.texture || '').toString().trim();
            if (vTexture && allTextures.indexOf(vTexture) === -1) {
                allTextures.push(vTexture);
            }
        });
        
        // Hiển thị tất cả các chất liệu
        if (allTextures.length > 0) {
            $('#texture-display').text(allTextures.join(', '));
        }
        
        // QUAN TRỌNG: Luôn cập nhật size_name và color_name vào form, ngay cả khi không tìm thấy variant
        // Điều này đảm bảo backend luôn nhận được giá trị mới nhất từ dropdown
        $('input[name="size_name"]').val(size);
        $('input[name="color_name"]').val(color);
        
        // Cập nhật texture từ variant được chọn (cho hidden input)
        if (variant) {
            texture = (variant.texture || '').toString().trim();
            $('#texture-select').val(texture);
            
            $('input[name="variant_id"]').val(variant.id);
            $('input[name="texture_name"]').val(texture);
            
            // DEBUG: Log variant found
            console.log('Variant found - ID:', variant.id, 'Size:', size, 'Color:', color, 'Texture:', texture);
            
            // Cập nhật giá hiển thị
            if (variant.price && parseFloat(variant.price) > 0) {
                $('.mtext-106').html('<span class="fw-bold">' + 
                    new Intl.NumberFormat('vi-VN').format(variant.price) + 'đ</span>');
            } else {
                if (hasPriceSale) {
                    $('.mtext-106').html('<span class="fw-bold">' + 
                        new Intl.NumberFormat('vi-VN').format(originalPriceSale) + 'đ</span>' +
                        '<span style="text-decoration: line-through; color: red; margin-left: 8px;">' + 
                        new Intl.NumberFormat('vi-VN').format(originalPrice) + 'đ</span>');
                } else {
                    $('.mtext-106').html(new Intl.NumberFormat('vi-VN').format(originalPrice) + 'đ');
                }
            }
        } else {
            // Nếu không tìm thấy variant, reset variant_id và texture_name
            $('input[name="variant_id"]').val('');
            $('input[name="texture_name"]').val('');
            
            // DEBUG: Log variant not found
            console.log('Variant NOT found for Size:', size, 'Color:', color);
            
            // Nếu không tìm thấy variant, giữ nguyên giá mặc định
            if (hasPriceSale) {
                $('.mtext-106').html('<span class="fw-bold">' + 
                    new Intl.NumberFormat('vi-VN').format(originalPriceSale) + 'đ</span>' +
                    '<span style="text-decoration: line-through; color: red; margin-left: 8px;">' + 
                    new Intl.NumberFormat('vi-VN').format(originalPrice) + 'đ</span>');
            } else {
                $('.mtext-106').html(new Intl.NumberFormat('vi-VN').format(originalPrice) + 'đ');
            }
        }
        
        // DEBUG: Log final form values
        console.log('Form values updated - size_name:', $('input[name="size_name"]').val(), 'color_name:', $('input[name="color_name"]').val(), 'variant_id:', $('input[name="variant_id"]').val());
    }
    
    // Khởi tạo: lọc button màu và cập nhật variant khi trang load
    filterColorButtons();
    updateVariant();

    // Event listener cho button size (click)
    $(document).on('click', '.size-variant-btn', function() {
        let selectedSize = $(this).data('size') || '';
        
        // Cập nhật hidden input
        $('#size-select').val(selectedSize);
        
        // Cập nhật style của các button size
        $('.size-variant-btn').css({
            'background-color': '#f5f5f5',
            'color': '#666',
            'border-color': '#e0e0e0'
        });
        $(this).css({
            'background-color': '#333',
            'color': '#fff',
            'border-color': '#333'
        });
        
        // Lọc và cập nhật button màu khi size thay đổi
        filterColorButtons();
        updateVariant();
    });
    
    // Event listener cho button màu (click)
    $(document).on('click', '.color-variant-btn', function() {
        let selectedColor = $(this).data('color') || '';
        
        // Cập nhật hidden input
        $('#color-select').val(selectedColor);
        
        // Cập nhật style của các button
        $('.color-variant-btn').css({
            'background-color': '#f5f5f5',
            'color': '#666',
            'border-color': '#e0e0e0'
        });
        $(this).css({
            'background-color': '#333',
            'color': '#fff',
            'border-color': '#333'
        });
        
        // Cập nhật variant
        updateVariant();
    });
    
    // Quantity controls
    $('.btn-num-product-down').on('click', function() {
        const input = $(this).siblings('.num-product');
        const currentValue = parseInt(input.val());
        if (currentValue > 1) {
            input.val(currentValue - 1);
        }
    });
    
    $('.btn-num-product-up').on('click', function() {
        const input = $(this).siblings('.num-product');
        const currentValue = parseInt(input.val());
        input.val(currentValue + 1);
    });
    
    // Sync trước khi submit - Đảm bảo giá trị mới nhất được cập nhật
    $('#add-to-cart-form').on('submit', function(e){
        // Gọi updateVariant() một lần nữa trước khi submit để đảm bảo giá trị mới nhất
        updateVariant();
        
        // DEBUG: Log trước khi submit
        console.log('Form submitting - size_name:', $('input[name="size_name"]').val(), 'color_name:', $('input[name="color_name"]').val(), 'variant_id:', $('input[name="variant_id"]').val());
        updateVariant();
    });
});
</script>
@endpush

