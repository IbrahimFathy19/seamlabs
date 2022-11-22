<?php

namespace App\Exceptions;

use App\Helpers\ResponseObject;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    use JsonExceptionHandlerTrait;
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
        'current_password',
        'password',
        'password_confirmation',
    ];


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return $this->apiException($request, $exception);
        }
        $response = new ResponseObject();
        if (App::environment('local', 'staging')) {
            $response->errors = [
                'message'   => $exception->getMessage()
            ];
            $response->exception = [
                'exception' => get_class($exception),
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
                'trace'     => $exception->getTrace()
            ];
            $response->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            return response()->json($response, $response->statusCode);
        }

        return parent::render($request, $exception);
    }
}
