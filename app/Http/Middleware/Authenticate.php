<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // هنا نتحقق من المسار لتحديد صفحة تسجيل الدخول المناسبة
            if ($request->is('admin/*')) {
                return route('admin.login.form');
            } elseif ($request->is('provider/*')) {
                return route('login.provider.form');
            } elseif ($request->is('user/*')) {
                return route('login.user.form');
            }

            // إذا لم ينطبق أي من الحالات السابقة، العودة إلى صفحة تسجيل الدخول الافتراضية
            return route('login.user.form');
        }

        return null;
    }

}
