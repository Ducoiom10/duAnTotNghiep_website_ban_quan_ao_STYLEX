

<?php $__env->startSection('title', 'Bài viết - ' . env('APP_NAME')); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <!-- Blog list -->
        <div class="col-md-8 col-lg-9 p-b-80">
            <div class="p-r-45 p-r-0-lg">

                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-b-63">
                        <a href="<?php echo e(route('blog.detail', $blog->slug)); ?>" class="hov-img0 how-pos5-parent">
                            <img src="<?php echo e($blog->thumbnail ? Storage::url($blog->thumbnail) : asset('client/images/blog-default.jpg')); ?>" alt="<?php echo e($blog->title); ?>">

                            <div class="flex-col-c-m size-123 bg9 how-pos5">
                                <span class="ltext-107 cl2 txt-center">
                                    <?php echo e($blog->created_at->format('d')); ?>

                                </span>
                                <span class="stext-109 cl3 txt-center">
                                    <?php echo e($blog->created_at->format('M Y')); ?>

                                </span>
                            </div>
                        </a>

                        <div class="p-t-32">
                            <h4 class="p-b-15">
                                <a href="<?php echo e(route('blog.detail', $blog->slug)); ?>" class="ltext-108 cl2 hov-cl1 trans-04">
                                    <?php echo e($blog->title); ?>

                                </a>
                            </h4>

                            <p class="stext-117 cl6">
                                <?php echo e(Str::limit(strip_tags($blog->content), 150, '...')); ?>

                            </p>

                            <div class="flex-w flex-sb-m p-t-18">
                                <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                                    <span>
                                        <span class="cl4">By</span> <?php echo e($blog->user->name ?? 'Admin'); ?>

                                        <span class="cl12 m-l-4 m-r-6">|</span>
                                    </span>

                                    <span>
                                        <?php echo e($blog->category->name ?? 'Uncategorized'); ?>

                                        <span class="cl12 m-l-4 m-r-6">|</span>
                                    </span>

                                    <span>
                                        <?php echo e($blog->tags->pluck('name')->join(', ')); ?>

                                    </span>
                                </span>

                                <a href="<?php echo e(route('blog.detail', $blog->slug)); ?>" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                    Xem chi tiết
                                    <i class="fa fa-long-arrow-right m-l-9"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- Pagination -->
                <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
                    <?php echo e($blogs->links('client.posts.pagination')); ?>

                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4 col-lg-3 p-b-80">
            <div class="side-menu">

                <!-- Search -->
                <div class="bor17 of-hidden pos-relative">
                    <form action="<?php echo e(route('blog.index')); ?>" method="GET">
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
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="bor18">
                                <a href="<?php echo e(route('blog.index', ['category' => $category->slug])); ?>" 
                                   class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                    <?php echo e($category->name); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <!-- Featured Products -->
                <div class="p-t-65">
                    <h4 class="mtext-112 cl2 p-b-33">Featured Products</h4>
                    <ul>
                        <?php $__currentLoopData = $product_feature; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex-w flex-t p-b-30">
                                <a href="" 
                                   class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                    <img src="<?php echo e($product->thumbnail ?? asset('client/images/no-image.jpg')); ?>" alt="<?php echo e($product->name); ?>">
                                </a>

                                <div class="size-215 flex-col-t p-t-8">
                                    <a href="" 
                                       class="stext-116 cl8 hov-cl1 trans-04">
                                        <?php echo e($product->name); ?>

                                    </a>
                                    <span class="stext-116 cl6 p-t-20">
                                        <?php echo e(number_format($product->price, 0, ',', '.')); ?>₫
                                    </span>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <!-- Tags -->
                <div class="p-t-50">
                    <h4 class="mtext-112 cl2 p-b-27">Tags</h4>
                    <div class="flex-w m-r--5">
                        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('blog.index', ['tag' => $tag->slug])); ?>" 
                               class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                <?php echo e($tag->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\blogs\index.blade.php ENDPATH**/ ?>