<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AppController;
use Closure;
use Illuminate\Support\Facades\Log;

class Auth extends AppController
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
        try {
            if($this->getAuthUser($request)){
                return $next($request);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Auth failed! Missing or invalid token'
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Error! Try again!'
            ]);
        }
    }
}
