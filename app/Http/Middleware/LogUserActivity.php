<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\LogActivityHelper;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('get')) {
            return $next($request);
        }
        if ($request->route()) {
            $routeName = $request->route()->getName() ?? 'unknown';
            $uri       = $request->path();

            LogActivityHelper::log(
                "Akses menu / halaman: {$routeName} ({$uri})"
            );
        }

        return $next($request);
    }
}
