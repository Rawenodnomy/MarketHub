<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->is_admin == 2) {
                return $next($request); 
            }
            return redirect('home')->with('error', 'У вас нет доступа на страницу администратора');
        } else {
            return redirect('login')->with('error', 'Войдите в систему'); // Перенаправление на страницу входа
        }
    }
}
