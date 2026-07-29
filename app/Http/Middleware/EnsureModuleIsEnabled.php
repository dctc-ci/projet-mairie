<?php

namespace App\Http\Middleware;

use App\Models\ModuleSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleIsEnabled
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        abort_unless(ModuleSetting::enabled($module), 404);

        return $next($request);
    }
}
