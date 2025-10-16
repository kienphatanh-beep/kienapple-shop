<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    // =======================
    // 🧩 ĐĂNG KÝ
    // =======================
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:user,username',
            'email'    => 'required|email|unique:user,email',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'password' => 'required|confirmed|min:6',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // ✅ Upload avatar
        $avatarPath = 'assets/images/user/default-avatar.png';
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/user'), $fileName);
            $avatarPath = 'assets/images/user/' . $fileName;
        }

        // ✅ Tạo tài khoản
        $user = User::create([
            'name'       => $request->name,
            'username'   => $request->username,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'password'   => Hash::make($request->password),
            'avatar'     => $avatarPath,
            'created_by' => Auth::id() ?? 1,
            'status'     => 1,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', '🎉 Đăng ký và đăng nhập thành công!');
    }

    // =======================
    // 🔑 ĐĂNG NHẬP
    // =======================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', '✅ Đăng nhập thành công!');
        }

        return back()->withErrors(['username' => 'Thông tin đăng nhập không đúng.'])
            ->onlyInput('username');
    }

    // =======================
    // 🚪 ĐĂNG XUẤT
    // =======================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', '👋 Đã đăng xuất.');
    }

    // =======================
    // 📧 QUÊN MẬT KHẨU (OTP)
    // =======================
    public function showForgotForm()
    {
        return view('auth.forgot');
    }

    public function sendOTP(Request $request)
    {
        $email = $request->isJson()
            ? ($request->json('email') ?? null)
            : $request->input('email');

        if (!$email) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập địa chỉ email hợp lệ.'], 400);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Email không tồn tại trong hệ thống.'], 404);
            }
            return back()->withErrors(['email' => 'Tài khoản không tồn tại.']);
        }

        // Xóa OTP cũ và tạo mới
        PasswordOtp::where('email', $email)->delete();
        $otp = rand(100000, 999999);

        PasswordOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        session(['reset_email' => $email, 'latest_otp' => $otp]);
        \Log::info("OTP gửi đến $email là: $otp");

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => "Mã OTP đã được gửi đến $email (hiệu lực 5 phút).", 'otp' => $otp]);
        }

        return redirect()->route('forgot.verifyForm')->with([
            'otp_toast' => "📩 Mã OTP của bạn là: $otp (hiệu lực 5 phút)",
            'latest_otp' => $otp
        ]);
    }

    public function showVerifyForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('forgot.show')->withErrors(['email' => 'Vui lòng nhập email trước.']);
        }

        $otpRecord = PasswordOtp::where('email', $email)->where('otp', $request->otp)->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Mã OTP không đúng.']);
        }

        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            $otpRecord->delete();
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn.']);
        }

        $otpRecord->delete();
        session(['otp_verified' => true]);

        return redirect()->route('forgot.resetForm')->with('success', '✅ Xác minh OTP thành công. Hãy đặt lại mật khẩu.');
    }

    public function showResetForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('forgot.show')->withErrors(['otp' => 'Bạn chưa xác minh OTP.']);
        }
        return view('auth.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate(['password' => 'required|confirmed|min:6']);
        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('forgot.show')->withErrors(['email' => 'Người dùng không tồn tại.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('success', '🔑 Đặt lại mật khẩu thành công!');
    }

    // =======================
    // ⚙️ CÀI ĐẶT / HỒ SƠ NGƯỜI DÙNG
    // =======================
    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Upload avatar
        $avatarPath = $user->avatar ?? 'assets/images/user/default-avatar.png';
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/user'), $fileName);
            $avatarPath = 'assets/images/user/' . $fileName;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'avatar' => $avatarPath,
        ]);

        return back()->with('success', '✅ Cập nhật thông tin thành công!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', '🔐 Mật khẩu đã được thay đổi thành công!');
    }
}
