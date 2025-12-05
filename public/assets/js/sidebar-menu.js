// Sidebar Menu JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Khôi phục trạng thái menu từ localStorage
    restoreMenuState();
    
    // Lưu trạng thái menu khi click
    const menuToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
    menuToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('aria-controls');
            const targetElement = document.getElementById(targetId);
            
            // Lưu trạng thái sau một chút delay để Bootstrap xử lý xong
            setTimeout(function() {
                const isExpanded = targetElement.classList.contains('show');
                localStorage.setItem('menu_' + targetId, isExpanded ? 'expanded' : 'collapsed');
            }, 100);
        });
    });
    
    // Ngăn chặn menu đóng khi click vào link con
    const menuLinks = document.querySelectorAll('.menu-dropdown .nav-link');
    menuLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Chỉ ngăn chặn nếu link có href thực sự (không phải #)
            if (this.getAttribute('href') && this.getAttribute('href') !== '#') {
                e.stopPropagation();
            }
        });
    });
    
    // Giữ menu mở khi click vào link con
    const dropdownLinks = document.querySelectorAll('.menu-dropdown a[href]');
    dropdownLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Ngăn chặn event bubble để không đóng menu cha
            e.stopPropagation();
        });
    });
});

function restoreMenuState() {
    // Khôi phục trạng thái cho tất cả menu
    const menuToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
    menuToggles.forEach(function(toggle) {
        const targetId = toggle.getAttribute('aria-controls');
        const savedState = localStorage.getItem('menu_' + targetId);
        
        if (savedState === 'expanded') {
            // Mở menu và cập nhật aria-expanded
            const targetElement = document.getElementById(targetId);
            targetElement.classList.add('show');
            toggle.setAttribute('aria-expanded', 'true');
        }
    });
}
