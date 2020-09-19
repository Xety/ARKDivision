<?php
namespace Xetaravel\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable   $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (($exception instanceof ModelNotFoundException ||
            $exception instanceof NotFoundHttpException) && $request->wantsJson()) {
            return response()->json([
                'data' => [],
                'error' => 'Resource not found!',
                'error_code' => 404,
                'version' => env('APP_API_VERSION')
            ], 404);
        }

        if ($exception instanceof \Ultraware\Roles\Exceptions\RoleDeniedException ||
            $exception instanceof \Ultraware\Roles\Exceptions\PermissionDeniedException ||
            $exception instanceof \Ultraware\Roles\Exceptions\LevelDeniedException) {
            //If the user is banished, redirect him to the banished page.
            if (Auth::check() && Auth::user()->hasRole('banni')) {
                return redirect()
                    ->route('page.banished');
            }

            return redirect()
                ->route('page.index')
                ->with('danger', 'You don\'t have the permission to view this page.');
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()
            ->guest(route('users.auth.login'))
            ->with('danger', 'You don\'t have the permission to view this page.');
    }
}
