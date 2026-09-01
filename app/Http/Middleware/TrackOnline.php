<?php

namespace App\Http\Middleware;

use App\Support\OnlineTracker;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// "Onlayn istifadəçi" izləməsi: hər səhifə sorğusunu canlılıq siqnalı kimi
// qeyd edir (bundan əlavə brauzerdə açıq qalan səhifələr üçün /api/heartbeat
// hər 20 saniyədən bir eyni siqnalı göndərir).
class TrackOnline
{
    public function handle(Request $request, Closure $next): Response
    {
        OnlineTracker::touch($request->session()->getId(), $request->user());
        return $next($request);
    }
}
