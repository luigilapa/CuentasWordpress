<?php

namespace CuentasFacturas\Http\Middleware;
use Illuminate\Auth\Guard;
use Closure;


class AdminMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth=$auth;
    }

    public function handle($request, Closure $next)
    {
        if($this->auth->user()->type != 'administrador')
        {
            return redirect()->to('401');
        }
        return $next($request);
    }
}
