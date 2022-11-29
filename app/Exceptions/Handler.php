<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        QueryException::class,
        NotFoundHttpException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 404,
                    'message' => 'Record not found.'
                ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 404);
            }
        });

        $this->renderable(function (QueryException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
                    'message' => 'Query error.'
                ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 400,
                    'message' => 'Method Not Allowed'
                ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 400);
            }
        });

        $this->renderable(function (\ErrorException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
                    'message' => $e->getMessage()
                ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
            }
        });

    }
}
