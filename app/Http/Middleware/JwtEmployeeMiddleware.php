<?php

namespace App\Http\Middleware;

use App\Utils\WebResponseUtils;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtEmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!Auth::guard('employee')->user()) {
                return WebResponseUtils::base(["message" => "Unauthorized Request"], "Unauthorized Request", 401);
            }
        } catch (TokenInvalidException $exception) {
            return WebResponseUtils::base(["message" => "Token Invalid"], "Token Invalid", 401);
        } catch (TokenExpiredException $exception) {
            return WebResponseUtils::base(["message" => "Token Expired"], "Token Expired", 401);
        } catch (Exception $exception) {
            return WebResponseUtils::base(["message" => "Unauthorized Request"], "Unauthorized Request", 401);
        }
        return $next($request);
    }
}
