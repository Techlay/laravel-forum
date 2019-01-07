<?php


namespace App\Http\Middleware;

use App\Channel;
use App\Trending;
use Closure;

class LoadCommonData
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->share('channels', Channel::all());
        view()->share('trending', app(Trending::class)->get());

        return $next($request);
    }
}
