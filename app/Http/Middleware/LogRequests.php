<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\RequestLog;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $request;
    protected $response;

    public function handle(Request $request, Closure $next): Response
    {
        $this->request = $request;
        $this->response = $next($request);

        return $this->response;
    }

    public function terminate($request, $response)
    {
        $input = $request->except([ '_token']);

        RequestLog::create([
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'input' => json_encode($input),
            'status_code' => method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null,
        ]);
    }
}
