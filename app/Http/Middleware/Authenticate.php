<?php

namespace App\Http\Middleware;

use App\Constants\ReturnStatusConstant;
use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            if (!$request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $response = new Controller();
                return $response->jsonError(ReturnStatusConstant::STATUS_UNLOGIN, 'Unauthorized.');
            }
        }

        return $next($request);
    }
}
