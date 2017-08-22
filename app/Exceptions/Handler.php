<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Utilities\Exceptions\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
    protected $response;

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        if (app()->environment() === 'testing') {
            throw $exception;
        }

        if ($request->header("env") == "dev") {
            if ($exception instanceof ModelNotFoundException) {
                $exception = new NotFoundHttpException($exception->getMessage(), $exception);
            }
            return parent::render($request, $exception);
        }

        return $this->response($exception);
    }

    /**
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function response(Exception $exception)
    {
        \Log::error($exception->getMessage());
        $status = 400;

        if ($this->isHttpException($exception)) {
            $status = $exception->getStatusCode();
        }
        $this->response['exception'] = class_basename(get_class($exception));
        $this->response['messages'] = $exception->getMessage();
        $this->response['code'] = $exception->getCode();

        $this->handleValidationException($exception);
        return response()->json($this->response, $status);
    }

    /**
     * @param Exception $e
     */
    private function handleValidationException(Exception $e)
    {
        if ($e instanceof ValidationException) {
            $this->response['messages'] = $e->getErrors();
        }
    }
}
