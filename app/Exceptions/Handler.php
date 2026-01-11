<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        // Spatie Laravel Permission
        if ($exception instanceof UnauthorizedException) {
            return redirect(route('backend.403'));
        }

        // Laravel Gate / Policy
        if ($exception instanceof AuthorizationException) {
            return redirect(route('backend.403'));
        }

        // Unauthenticated users
        if ($exception instanceof AuthenticationException) {
            return redirect('/login');
        }

        // 403 fallback
        if ($exception instanceof AccessDeniedHttpException) {
            return redirect(route('backend.403'));
        }

        // Custom 404 page
        if ($exception instanceof NotFoundHttpException) {
            // Return your custom 404 page with proper HTTP status
            return response()->view('Backend.Pages.Errors.404-Page', [], 404);
        }
        return parent::render($request, $exception);
    }
}
