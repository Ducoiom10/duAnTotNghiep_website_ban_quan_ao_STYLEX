<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    //
    public function verify($token){
        try {
            $user = User::where('verification_token', $token)->first(); 
        
            if(!$user){
                $msg = 'Mã xác thực không hợp lệ hoặc đã được sử dụng. Vui lòng kiểm tra lại email hoặc đăng ký tài khoản mới.';
                return view('admin.auth.verification.verification-message', compact('msg'));
            }

            if($user->token_expires_at && $user->token_expires_at < Carbon::now()){
                $msg = 'Mã xác minh đã hết hạn. Vui lòng yêu cầu gửi email xác minh mới.';
                return view('admin.auth.verification.verification-message', compact('msg'));
            }

            // Xác thực thành công
            $user->is_verified = 1;
            $user->email_verified_at = Carbon::now();
            $user->verification_token = null;
            $user->token_expires_at = null;
            $user->save();

            $msg = 'Xác thực email thành công! Bạn có thể đăng nhập ngay bây giờ.';
            return view('admin.auth.verification.verification-message', compact('msg'));
        } catch (\Exception $e) {
            $msg = 'Đã xảy ra lỗi trong quá trình xác thực. Vui lòng thử lại sau.';
            return view('admin.auth.verification.verification-message', compact('msg'));
        }
    }
}