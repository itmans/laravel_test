<?php

namespace App\Http\Middleware;

use App\Models\ErrorLog;
use App\Models\ReqLog;
use Illuminate\Http\Request;

class Logs
{
    public function handle(Request $request, \Closure $next)
    {
        $response = $next($request);
        $log = [
            'path' => $request->getUri(),
            'method' => $request->getMethod(),
            'request_data' => $request->all(),
            'response_data' => $response->getContent()
        ];
        $status = $response->status();
        if ($status == 200) {
            (new ReqLog())->createTable()->create($log);
        } else {
            (new ErrorLog())->createTable()->create($log);
        }
        return $response;
    }
}
