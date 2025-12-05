<?php

return [
    'disk'            => 'public',
    'quality'         => 88, 

    // Chỉ cần max-width cho từng size (không upscale)
    'sizes' => [
        'lg' => 1600, // ảnh hiển thị lớn
        'md' => 1024,
        'sm' => 640,
    ],

    // Xuất nhiều định dạng để trình duyệt chọn
    'formats'         => ['webp', 'jpg'],

    // Lưu kèm 1 bản gốc để fallback khi ảnh nhỏ hơn lg
    'backup_original' => true,
    'originals_root'  => 'products',
];
