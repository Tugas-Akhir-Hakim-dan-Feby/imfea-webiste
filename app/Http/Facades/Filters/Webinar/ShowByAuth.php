<?php

namespace App\Http\Facades\Filters\Webinar;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class ShowByAuth
{
    public function handle(Builder $query, Closure $next)
    {
        if (!request()->has('auth')) {
            return $next($query);
        }

        if (request('auth') == 'false' && request('auth') == false) {
            return $next($query);
        }

        $query->whereHas('webinarParticipant');

        return $next($query);
    }
}
