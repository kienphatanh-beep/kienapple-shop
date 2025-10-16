<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::guard('admin')->user();
            if ($user->roles === 'admin') {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');

            }
        
            Auth::guard('admin')->logout();
            return back()->withErrors(['username' => 'Tài khoản không có quyền truy cập admin.']);
        }
        
        return back()->withErrors(['username' => 'Thông tin đăng nhập không chính xác.']);
        
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
        
    }
}
