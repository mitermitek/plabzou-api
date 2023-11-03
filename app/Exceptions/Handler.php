<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if ($request->is('api/*')) {
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Erreur de validation',
                    'errors' => $e->errors(),
                ], 422);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'Pas authentifié',
                ], 401);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'Ressource non trouvée',
                ], 404);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Route non trouvée',
                ], 404);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => 'Méthode non autorisée',
                ], 405);
            }

            if ($e instanceof QueryException) {
                return response()->json([
                    'message' => 'Erreur de base de données',
                ], 500);
            }

            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'message' => 'Pas autorisé',
                ], 403);
            }

            if ($e instanceof TokenMismatchException) {
                return response()->json([
                    'message' => 'Token invalide',
                ], 419);
            }

            if ($e instanceof UnauthorizedException) {
                return response()->json([
                    'message' => 'Pas autorisé',
                ], 401);
            }

            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 400);
        }

        return parent::render($request, $e);
    }
}
