<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Not Found',
                ], 404);
            }
        });

        $this->renderable(function (\Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $code = 500;
                $ret = [
                    'error' => env('APP_DEBUG') ? $e->getMessage() : 'Internal Server Error',
                ];
                if (env('APP_DEBUG')) {
                    $ret['trace'] = $e->getTrace();
                    $code = $e->getCode() ?: $code;
                }
                return response($ret, $code);
            }
        });
    }
}
