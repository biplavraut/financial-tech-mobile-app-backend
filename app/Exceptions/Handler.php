<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use App\Exceptions\Api\Handler as ApiHandler;
use Exception;

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
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->acceptsHtml()) {
            return parent::render($request, $exception);
        }

        // if api is custom made then we will render it form its respective render() method
        if ($request->wantsJson() && $this->isInbuiltException($exception)) {
            return $this->renderJson($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * @param Throwable $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function renderJson(Throwable $exception)
    {
        $handler = new ApiHandler($exception);

        return failureResponse($handler->getMessage(), $handler->getCustomStatusCode(), $handler->getCustomStatusCode());
    }

    /**
     * @param Exception $exception
     *
     * @return bool
     */
    private function isInbuiltException(Exception $exception)
    {
        // if full path of class has Api in it, it is custom exception else inbuilt
        return strpos(get_class($exception), 'Api') === false;
    }
}
