<?php

namespace Scalex\Zero\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Log;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Znck\Repositories\Exceptions\DeleteResourceException;
use Znck\Repositories\Exceptions\NotFoundResourceException;
use Znck\Repositories\Exceptions\ResourceException;
use Znck\Repositories\Exceptions\StoreResourceException;
use Znck\Repositories\Exceptions\UpdateResourceException;

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
        \Illuminate\Validation\ValidationException::class,
        \Znck\Repositories\Exceptions\ResourceException::class,
    ];

    /**
     * @param \Exception $e
     */
    protected function sentryCapture(Exception $e)
    {
        if (app()->environment('production') and $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return redirect()->guest('login');
    }

    protected function unauthenticatedApi($request, AuthenticationException $exception)
    {
        return \Response::json(['error' => 'unauthenticated'], 403);
    }

    /**
     * Render an exception into a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     *
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function render($request, Exception $e)
    {
        if (Str::startsWith($request->getPathInfo(), ['/api', '/broadcasting'])) {
            return $this->renderForApi($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Render an exception into a response for JSON API.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     *
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function renderForApi($request, $e)
    {
        if (
            $e instanceof UpdateResourceException or
            $e instanceof StoreResourceException or
            $e instanceof DeleteResourceException
        ) {
            return $this->convertValidationExceptionToJson($e, $request);
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticatedApi($request, $e);
        } elseif ($e instanceof AuthorizationException) {
            return \Response::json(['message' => 'You are not authorised to access this content.'], Response::HTTP_UNAUTHORIZED);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToJson($e, $request);
        } elseif (
            $e instanceof NotFoundHttpException or
            $e instanceof ModelNotFoundException or
            $e instanceof NotFoundResourceException
        ) {
            return \Response::json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } elseif ($e instanceof HttpException and $e->getStatusCode() >= 400 and $e->getStatusCode() < 500) {
            return \Response::json(['message' => $e->getMessage()], $e->getStatusCode());
        }

        $response = ['message' => 'Whoops! something very bad just happened!'];

        $context = [
            'error' => get_class($e),
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => FlattenException::create($e)->toArray(),
        ];

        Log::error('UNKNOWN EXCEPTION: ' . get_class($e), $context);
        $this->sentryCapture($e);


        if (config('app.debug')) {
            $response += ['debug' => $context];
        }

        return \Response::json($response, 500);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param ValidationException|ResourceException $e
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function convertValidationExceptionToJson($e, $request)
    {
        return \Response::json(
            [
                'message' => $e->getMessage(),
                'errors' => $e instanceof ValidationException ? $e->validator->getMessageBag() : $e->getErrors(),
            ],
            422
        );
    }

    public function report(Exception $e)
    {
        $this->sentryCapture($e);

        parent::report($e);
    }
}
