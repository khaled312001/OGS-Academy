<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('admin.login');
        }
        if (! $user->is_active) {
            auth()->logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'الحساب غير نشط — تواصل مع مدير النظام.']);
        }
        if (! $user->isEditor()) {
            abort(403, 'لا تملك الصلاحيات اللازمة.');
        }
        return $next($request);
    }
}
