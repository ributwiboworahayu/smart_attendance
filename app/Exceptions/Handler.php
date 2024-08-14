<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return Response|JsonResponse|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        // if request prefix is api
        if ($request->is('api/*')) {

            if ($e instanceof HttpExceptionInterface) {
                return match ($e->getStatusCode()) {
                    400 => response()->json([
                        'status' => "error",
                        'message' => 'Bad request'
                    ], 400),
                    401 => response()->json([
                        'status' => "error",
                        'message' => 'Unauthorized'
                    ], 401),
                    404 => response()->json([
                        'status' => "error",
                        'message' => 'Not found'
                    ], 404),
                    405 => response()->json([
                        'status' => "error",
                        'message' => 'Method not allowed'
                    ], 405),
                    429 => response()->json([
                        'status' => "error",
                        'message' => 'Too many requests'
                    ], 429),
                    503 => response()->json([
                        'status' => "error",
                        'message' => 'Under maintenance'
                    ], 503),
                    default => parent::render($request, $e),
                };
            }

            // check if unauthenticated
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'status' => "error",
                    'message' => 'Unauthorized'
                ], 401);
            }

            if (!$request->has('grant_type')) {
                return match (config('app.debug')) {
                    true => response()->json([
                        'status' => "error",
                        'message' => [
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                            'message' => $e->getMessage()
                        ]
                    ], 500),
                    default => response()->json([
                        'status' => "error",
                        'message' => 'Internal server error'
                    ], 500),
                };
            }
        }

        return parent::render($request, $e);
    }
}
