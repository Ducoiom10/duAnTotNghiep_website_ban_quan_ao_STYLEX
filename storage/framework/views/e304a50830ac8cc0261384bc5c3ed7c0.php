<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $detailUrl = \Illuminate\Support\Facades\Route::has('client.posts.show')
        ? route('client.posts.show', $post->slug)
        : (\Illuminate\Support\Facades\Route::has('blog.detail') ? route('blog.detail', $post->slug) : '#');
?>
<div class="p-b-63">
    <a href="<?php echo e($detailUrl); ?>" class="hov-img0 how-pos5-parent">
        <img src="<?php echo e(asset('assets/images/posts/blog-04.jpg')); ?>" alt="IMG-BLOG">

        <div class="flex-col-c-m size-123 bg9 how-pos5">
            <span class="ltext-107 cl2 txt-center">
                <?php echo e($post -> created_at->format('d')); ?>

            </span>

            <span class="stext-109 cl3 txt-center">
                <?php echo e($post -> created_at->format('M Y')); ?>

            </span>
        </div>
    </a>

    <div class="p-t-32">
        <h4 class="p-b-15">
            <a href="<?php echo e($detailUrl); ?>" class="ltext-108 cl2 hov-cl1 trans-04">
                <?php echo e($post->title); ?>

            </a>
        </h4>

        <p class="stext-117 cl6">
            <?php echo e(Str::limit(strip_tags($post->content), 150, '...')); ?>

        </p>

        <div class="flex-w flex-sb-m p-t-18">
            <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                <span>
                    <span class="cl4">By</span> <?php echo e($post->author->name ?? 'Admin'); ?>

                </span>
            </span>

            <a href="<?php echo e($detailUrl); ?>" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                Continue Reading
                <i class="fa fa-long-arrow-right m-l-9"></i>
            </a>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
    <style>
        .pagination .page-item.pg-grey .page-link {
            background: #f0f0f0;
            color: #555;
            border-color: #e0e0e0;
        }
        .pagination .page-item.pg-grey .page-link:hover {
            background: #e9e9e9;
            color: #333;
        }
        .pagination .page-item .page-link {
            border-radius: 8px;
            padding: 8px 14px;
            margin: 0 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            transition: all .2s ease;
        }
        .pagination .page-item.active .page-link {
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
    </style>
    <?php echo e($posts->links('client.posts.pagination')); ?>

</div>

<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\posts\_list.blade.php ENDPATH**/ ?>