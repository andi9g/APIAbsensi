<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class jwtGuard
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $request->merge(["idinstansi", $user->idinstansi]);
            // dd($user->idinstansi);
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'error']);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'error']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'error']);
        }

        return $next($request);
    }
}
