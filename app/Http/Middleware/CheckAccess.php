<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $forbidden = $request->session()->get('access')['forbidden_list'];
        $uri =  $request->segment(2) ? $request->segment(1).'/'.$request->segment(2) : $request->segment(1);
        if (in_array($uri, $forbidden)) {
            return redirect('home');
            return abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
