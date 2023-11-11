<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->user()->roles[0]->id == User::MEMBER &&
            !$request->user()->membership

        ) {
            return redirect(route('web.member.register.index'));
        }

        if (
            $request->user()->roles[0]->id == User::MEMBER &&
            $request->user()->payment::PENDING == $request->user()->payment->status

        ) {
            return redirect(route('web.invoice.show', $request->user()->payment->external_id));
        }

        return $next($request);
    }
}
