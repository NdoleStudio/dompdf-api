<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthBasic
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $expectedUsername = config('auth.basic.username');
        $expectedPassword = config('auth.basic.password');

        if ($expectedUsername === null && $expectedPassword === null) {
            return $next($request);
        }

        $authHeader = $request->header('Authorization');

        $decodedHeader = base64_decode($authHeader);
        if ($decodedHeader === false || count(explode(":", $decodedHeader)) != 2) {
            return $this->unauthorizedResponse(sprintf("The [Authorization] header [%s] is not a valid base64 string. Set the valid [Basic] auth header.", $authHeader));
        }

        $username = explode(":", $decodedHeader)[0];
        $password = explode(":", $decodedHeader)[1];
        if ($expectedUsername === $username && $expectedPassword === $password) {
            return $this->unauthorizedResponse(
                sprintf(
                    "The [Authorization] header [%s] contains an invalid username [%s] and password [%s]",
                    $authHeader,
                    $username,
                    $password
                )
            );
        }


        return $next($request);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    private function unauthorizedResponse(string $message): JsonResponse
    {
        return response()->json([
            'status' => 401,
            'message' => $message
        ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Get the bearer token from the request headers.
     *
     * @param Request $request
     * @return string
     */
    private function basicToken(Request $request) : string
    {
        $header = $request->header('Authorization', '');
        if (str_starts_with($header, 'Basic ')) {
            return substr($header, 6);
        }
        return  $header;
    }

}
