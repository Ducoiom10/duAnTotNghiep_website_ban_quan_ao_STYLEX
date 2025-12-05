

<?php $__env->startSection('title', $blog->title); ?>
<?php $__env->startSection('content'); ?>
<section class="bg0 p-t-52 p-b-20">
    <div class="container">
        <div class="row">
            <!-- Blog Detail -->
            <div class="col-md-8 col-lg-9 p-b-80">
                <div class="p-r-45 p-r-0-lg">

                    <!-- Blog Image -->
                    <div class="wrap-pic-w how-pos5-parent">
                        <img src="<?php echo e($blog->thumbnail ? Storage::url($blog->thumbnail) : asset('client/images/blog-default.jpg')); ?>" alt="<?php echo e($blog->title); ?>">

                        <div class="flex-col-c-m size-123 bg9 how-pos5">
                            <span class="ltext-107 cl2 txt-center">
                                <?php echo e($blog->created_at->format('d')); ?>

                            </span>
                            <span class="stext-109 cl3 txt-center">
                                <?php echo e($blog->created_at->format('M Y')); ?>

                            </span>
                        </div>
                    </div>

                    <!-- Blog Info -->
                    <div class="p-t-32">
                        <span class="flex-w flex-m stext-111 cl2 p-b-19">
                            <span>
                                <span class="cl4">By</span> <?php echo e($blog->user->name ?? 'Admin'); ?>

                                <span class="cl12 m-l-4 m-r-6">|</span>
                            </span>

                            <span>
                                <?php echo e($blog->created_at->format('d M, Y')); ?>

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

                        <h4 class="ltext-109 cl2 p-b-28">
                            <?php echo e($blog->title); ?>

                        </h4>

                        <div class="stext-117 cl6 p-b-26">
                            <?php echo $blog->content; ?>

                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="flex-w flex-t p-t-16">
                        <span class="size-216 stext-116 cl8 p-t-4">Tags</span>
                        <div class="flex-w size-217">
                            <?php $__currentLoopData = $blog->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="" 
                                   class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                   <?php echo e($tag->name); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Related Blogs -->
                    <?php if($related_blogs->count()): ?>
                    <div class="p-t-50">
                        <h5 class="mtext-113 cl2 p-b-20">Related Posts</h5>
                        <div class="row">
                            <?php $__currentLoopData = $related_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-6 col-lg-4 p-b-30">
                                    <a href="<?php echo e(route('blog.detail', $related->slug)); ?>" class="hov-img0 how-pos5-parent">
                                        <img src="<?php echo e($related->thumbnail ?? asset('client/images/blog-default.jpg')); ?>" alt="<?php echo e($related->title); ?>">
                                    </a>
                                    <div class="p-t-15">
                                        <a href="<?php echo e(route('blog.detail', $related->slug)); ?>" class="stext-112 cl2 hov-cl1 trans-04">
                                            <?php echo e(Str::limit($related->title, 50)); ?>

                                        </a>
                                        <p class="stext-109 cl6 p-t-5">
                                            <?php echo e($related->created_at->format('d M Y')); ?>

                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Comment form -->
                    <div class="p-t-40">
                        <h5 class="mtext-113 cl2 p-b-12">Leave a Comment</h5>
                        <p class="stext-107 cl6 p-b-40">
                            Your email address will not be published. Required fields are marked *
                        </p>

                        <form>
                            <div class="bor19 m-b-20">
                                <textarea class="stext-111 cl2 plh3 size-124 p-lr-18 p-tb-15" 
                                          name="cmt" placeholder="Comment..."></textarea>
                            </div>
                            <div class="bor19 size-218 m-b-20">
                                <input class="stext-111 cl2 plh3 size-116 p-lr-18" 
                                       type="text" name="name" placeholder="Name *">
                            </div>
                            <div class="bor19 size-218 m-b-20">
                                <input class="stext-111 cl2 plh3 size-116 p-lr-18" 
                                       type="text" name="email" placeholder="Email *">
                            </div>
                            <div class="bor19 size-218 m-b-30">
                                <input class="stext-111 cl2 plh3 size-116 p-lr-18" 
                                       type="text" name="web" placeholder="Website">
                            </div>
                            <button class="flex-c-m stext-101 cl0 size-125 bg3 bor2 hov-btn3 p-lr-15 trans-04">
                                Post Comment
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4 col-lg-3 p-b-80">
                <div class="side-menu">

                    <!-- Search -->
                    <div class="bor17 of-hidden pos-relative">
                        <form action="" method="GET">
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
                                    <a href="" 
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
                                        <img src="<?php echo e($product->image_url ?? asset('client/images/no-image.jpg')); ?>" 
                                             alt="<?php echo e($product->name); ?>">
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
                                <a href="" 
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
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\blogs\detail.blade.php ENDPATH**/ ?>