<!-- Chat Icon Button -->
<div class="position-fixed" id="chatIconWrapper" style="bottom: 100px; right: 30px; z-index: 10001 !important; display: block !important; visibility: visible !important;">
    <button class="btn btn-dark rounded-circle shadow-lg d-flex align-items-center justify-content-center" 
            id="chatIconButton" 
            aria-label="Mở chat" 
            style="width: 60px; height: 60px; font-size: 28px;">
        <i class="zmdi zmdi-comment-text"></i>
    </button>
    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" 
          id="chatBadge" 
          style="display: none;">1</span>
</div>

<!-- Chat Box Container -->
<div class="card position-fixed shadow-lg border d-flex flex-column" 
     id="chatBoxContainer" 
     style="z-index: 10002; width: 350px; height: 450px; display: none !important;">
    
    <!-- Chat Header -->
    <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between px-3 py-3" 
         style="border-radius: 12px 12px 0 0; background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%) !important;">
        <div class="d-flex align-items-center gap-3 flex-grow-1" style="min-width: 0;">
            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" 
                 style="width: 42px; height: 42px; border: 2px solid rgba(255,255,255,0.3);">
                <i class="zmdi zmdi-account text-white" style="font-size: 20px;"></i>
            </div>
            <div class="flex-grow-1" style="min-width: 0;">
                <h6 class="mb-1 d-flex align-items-center gap-2" style="font-size: 15px; font-weight: 600; line-height: 1.3;">
                    <span class="badge bg-success rounded-circle d-inline-block shadow-sm" style="width: 9px; height: 9px; padding: 0; animation: blink 2s infinite;"></span>
                    <span>Admin Support</span>
                </h6>
                <small class="text-white-50 d-block" style="font-size: 11px; line-height: 1.4; opacity: 0.9;">
                    <span>Thường phản hồi trong vài phút</span>
                    <span class="d-block mt-1 d-flex align-items-center" style="font-size: 10px; opacity: 0.8;" id="chatCurrentDate"></span>
                </small>
            </div>
        </div>
        <button class="btn btn-link text-white p-0 flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" 
                id="chatCloseBtn" 
                aria-label="Đóng chat"
                style="width: 34px; height: 34px; transition: background 0.3s ease; background: rgba(255,255,255,0.1); text-decoration: none !important;">
            <i class="zmdi zmdi-close" style="font-size: 18px; text-decoration: none !important;"></i>
        </button>
    </div>

    <!-- Chat Messages Area -->
    <div class="card-body p-4 overflow-auto" 
         id="chatMessages" 
         style="flex: 1; min-height: 0; background: #ffffff;">
        <div class="text-center p-5 bg-gradient rounded-4 shadow-sm border" 
             style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important; margin: 10px 0; border: 1px solid #e9ecef !important;">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light shadow-sm" 
                     style="width: 64px; height: 64px; background: linear-gradient(135deg, #f0f0f0 0%, #ffffff 100%) !important;">
                    <i class="zmdi zmdi-comment-text d-block" style="font-size: 36px; color: #1a1a1a; opacity: 0.6;"></i>
                </div>
            </div>
            <h6 class="mb-3 fw-bold" style="font-size: 17px; color: #333; letter-spacing: 0.3px;">Xin chào! 👋</h6>
            <p class="mb-0 text-muted" style="font-size: 13px; line-height: 1.6; color: #666; max-width: 280px; margin: 0 auto;">Chúng tôi ở đây để giúp bạn. Hãy gửi tin nhắn cho chúng tôi!</p>
        </div>
    </div>

    <!-- Chat Input Area -->
    <div class="card-footer bg-white border-top px-3 py-3" 
         style="border-radius: 0 0 12px 12px; border-top: 1px solid #e9ecef !important;">
        <div class="position-relative">
            <input 
                type="text" 
                class="form-control border-0 shadow-sm" 
                id="chatInput" 
                placeholder="Nhập tin nhắn của bạn..."
                autocomplete="off"
                style="
                    height: 44px;
                    border-radius: 22px;
                    border: 1.5px solid #e0e0e0 !important;
                    padding: 0 50px 0 16px;
                    background: #f8f9fa;
                    font-size: 13px;
                    outline: none;
                    transition: all 0.3s ease;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
                ">
            <button class="btn btn-dark position-absolute p-0 d-flex align-items-center justify-content-center" 
                    id="chatSendBtn" 
                    aria-label="Gửi tin nhắn"
                    style="
                        width: 38px;
                        height: 38px;
                        right: 3px;
                        top: 3px;
                        border-radius: 50%;
                        font-size: 16px;
                        transition: all 0.3s ease;
                        border: none;
                        background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%) !important;
                        box-shadow: 0 2px 6px rgba(0,0,0,0.15) !important;
                    ">
                <i class="zmdi zmdi-mail-send text-white"></i>
            </button>
        </div>
    </div>
</div>
<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\partials\chat.blade.php ENDPATH**/ ?>