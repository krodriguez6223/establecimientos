<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Categoria;
use Illuminate\Http\Request;

class RevisarEstablecimiento
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */


    public function handle(Request $request, Closure $next)
    {
         
        //si el usuariologueado tiene registrado establecimiento lo envia a editar
        if(Auth()->user()->establecimiento ){
            
           return redirect('/edit');
        }
        return $next($request);
    }
}
