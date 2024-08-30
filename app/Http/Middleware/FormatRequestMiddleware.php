<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormatRequestMiddleware
{
    /**
     * Handle an incoming request's response format.
     *
     * @param Request $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // XML
        if ($request->accepts('application/xml')) {
            $data = $response->getOriginalContent();

            $xml = array_to_xml($request);
            return response($xml, $response->getStatusCode())
                ->header('Content-Type', 'application/xml');

        }// elseif - Handle different formats here

        // Default: JSON
        return $response->header('Content-Type', 'application/json');
    }
}
