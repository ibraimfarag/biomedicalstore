<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        if (env('SUBSCRIPTION_ACTIVE', true) != true) {
            // إذا الاشتراك غير مفعل، اسمح فقط بصفحة انتهاء الاشتراك
            if ($request->is('subscription-ended')) {
                return $next($request);
            }
            return redirect('/subscription-ended');
        } else {
            // إذا الاشتراك مفعل، امنع الوصول لصفحة انتهاء الاشتراك
            if ($request->is('subscription-ended')) {
                return redirect('/');
            }
        }
        return $next($request);
    }
}
