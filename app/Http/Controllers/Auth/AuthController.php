<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Models\User;
use App\Traits\LoggableTrait;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    use LoggableTrait;
    public function registerView(){
        try {
            //code...
            return view('auth.register');
        } catch (\Exception $e) {
            return abort(404, "Có gì đó không ổn!");
        }
    }
    public function register(RegisterRequest $request){
        try {
            //code...
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->password = Hash::make($request->password);
            $user->verification_token = Str::random(60);
            $user->token_expires_at = Carbon::now()->addHour();
            $user->save();

            $this->sendVerificationMail($user);
            return back()->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
        } catch (\Exception $e) {
            $this->logError($e);
            return back()->with('error', $e->getMessage());
        }
    }

    protected function sendVerificationMail($user)
    {
        try {
            $verificationUrl = url('/verify/'.$user->verification_token);
            $fromEmail = config('mail.from.address', env('MAIL_FROM_ADDRESS', 'noreply@stylex.com'));
            $fromName = config('mail.from.name', env('MAIL_FROM_NAME', 'StyleX'));
            
            Mail::send('admin.mails.verification', [
                'name' => $user->name, 
                'url' => $verificationUrl
            ], function($message) use ($user, $fromEmail, $fromName) {
                $message->from($fromEmail, $fromName);
                $message->to($user->email);
                $message->subject('Xác thực email - ' . config('app.name'));
            });
        } catch (\Exception $e) {
            Log::error('Lỗi gửi email xác thực: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

        public function loginView(){
        try {
            //code...
            return view('auth.login');
        } catch (\Exception $e) {
            return abort(404, "Có gì đó không ổn!");
        }
    }

        public function login(LoginRequest $request){
        try {
            //code...
            $userLogin = $request->only('email', 'password');
            if(Auth::attempt($userLogin)){
                if(Auth::user()->email_verified_at == null){
                    Auth::logout();
                    return back()->with('error', 'Hãy xác thực tài khoản của bạn!');
                }
                // Merge session cart into DB once after login
                try {
                    $sessionItems = $request->session()->get('cart.items', []);
                    if (!empty($sessionItems)) {
                        foreach ($sessionItems as $it) {
                            if (empty($it['product_id'])) { continue; }
                            $existing = Cart::where('user_id', Auth::id())
                                ->where('product_id', $it['product_id'])
                                ->where('variant_id', $it['variant_id'] ?? null)
                                ->first();
                            if ($existing) {
                                $existing->quantity = (int)$existing->quantity + (int)($it['quantity'] ?? 1);
                                $existing->save();
                            } else {
                                Cart::create([
                                    'user_id' => Auth::id(),
                                    'session_id' => null,
                                    'product_id' => (int)$it['product_id'],
                                    'variant_id' => $it['variant_id'] ?? null,
                                    'quantity' => (int)($it['quantity'] ?? 1),
                                ]);
                            }
                        }
                        // clear session cart after merge
                        $request->session()->forget('cart.items');
                    }
                } catch (\Throwable $e) {
                    // ignore merge errors to not block login
                }
                if(Auth::user()->role == 1 || Auth::user()->role == 2){
                    return redirect()->route('admin.dashboard');
                }else{
                    return redirect()->route('user.dashboard');
                }
            }else{
                 return back()->with('error', 'Email hoặc mật khẩu không hợp lệ!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function logout(Request $request){
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('success', 'Đăng xuất thành công!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}