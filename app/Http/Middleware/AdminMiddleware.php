<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để truy cập');
        } else if(Auth::user()->role_id != 1) {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập');
        }
        return $next($request);
    }
}
