<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle($request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng đã đăng nhập và có quyền admin
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->roles !== 'admin') {
            return redirect()->route('admin.login');
        }
        

        return $next($request);
    }
}
 