@extends('client.layouts.app')

@section('title', 'Bài viết - ' . env('APP_NAME'))
@section('content')
<div class="container">
    <div class="row">
        <!-- Blog list -->
        <div class="col-md-8 col-lg-9 p-b-80">
            <div class="p-r-45 p-r-0-lg">

                @foreach ($blogs as $blog)
                    <div class="p-b-63">
                        <a href="{{ route('blog.detail', $blog->slug) }}" class="hov-img0 how-pos5-parent">
                            <img src="{{ $blog->thumbnail ? Storage::url($blog->thumbnail) : asset('client/images/blog-default.jpg') }}" alt="{{ $blog->title }}">

                            <div class="flex-col-c-m size-123 bg9 how-pos5">
                                <span class="ltext-107 cl2 txt-center">
                                    {{ $blog->created_at->format('d') }}
                                </span>
                                <span class="stext-109 cl3 txt-center">
                                    {{ $blog->created_at->format('M Y') }}
                                </span>
                            </div>
                        </a>

                        <div class="p-t-32">
                            <h4 class="p-b-15">
                                <a href="{{ route('blog.detail', $blog->slug) }}" class="ltext-108 cl2 hov-cl1 trans-04">
                                    {{ $blog->title }}
                                </a>
                            </h4>

                            <p class="stext-117 cl6">
                                {{ Str::limit(strip_tags($blog->content), 150, '...') }}
                            </p>

                            <div class="flex-w flex-sb-m p-t-18">
                                <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                                    <span>
                                        <span class="cl4">By</span> {{ $blog->user->name ?? 'Admin' }}
                                        <span class="cl12 m-l-4 m-r-6">|</span>
                                    </span>

                                    <span>
                                        {{ $blog->category->name ?? 'Uncategorized' }}
                                        <span class="cl12 m-l-4 m-r-6">|</span>
                                    </span>

                                    <span>
                                        {{ $blog->tags->pluck('name')->join(', ') }}
                                    </span>
                                </span>

                                <a href="{{ route('blog.detail', $blog->slug) }}" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                    Xem chi tiết
                                    <i class="fa fa-long-arrow-right m-l-9"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
                    {{ $blogs->links('client.posts.pagination') }}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4 col-lg-3 p-b-80">
            <div class="side-menu">

                <!-- Search -->
                <div class="bor17 of-hidden pos-relative">
                    <form action="{{route('blog.index')}}" method="GET">
                        <input class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" 
                               type="text" name="search" placeholder="Search...">
                        <button class="flex-c-m size-122 ab-t-r fs-18 cl4 hov-cl1 trans-04">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Categories -->
                <div class="p-t-55">
                    <h4 class="mtext-112 cl2 p-b-33">Categories</h4>
                    <ul>
                        @foreach ($categories as $category)
                            <li class="bor18">
                                <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
                                   class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Featured Products -->
                <div class="p-t-65">
                    <h4 class="mtext-112 cl2 p-b-33">Featured Products</h4>
                    <ul>
                        @foreach ($product_feature as $product)
                            <li class="flex-w flex-t p-b-30">
                                <a href="" 
                                   class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                    <img src="{{ $product->thumbnail ?? asset('client/images/no-image.jpg') }}" alt="{{ $product->name }}">
                                </a>

                                <div class="size-215 flex-col-t p-t-8">
                                    <a href="" 
                                       class="stext-116 cl8 hov-cl1 trans-04">
                                        {{ $product->name }}
                                    </a>
                                    <span class="stext-116 cl6 p-t-20">
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tags -->
                <div class="p-t-50">
                    <h4 class="mtext-112 cl2 p-b-27">Tags</h4>
                    <div class="flex-w m-r--5">
                        @foreach ($tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" 
                               class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
