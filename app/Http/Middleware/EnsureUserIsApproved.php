<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        if ($request->user()->status() == 'pending') {
            session()->flash('warning', __('auth.successfully_registered'));
            return redirect()->route('home');
        }
        if ($request->user()->status() == 'refused') {
            session()->flash('danger', __('Your subscription request has been refused.'));
            return redirect()->route('home');
        }

        if ($request->user()->status() == 'disabled') {
            session()->flash('warning', __('Your account has been disabled by the administrator'));
            return redirect()->route('home');
        }

        return $next($request);
    }
}
