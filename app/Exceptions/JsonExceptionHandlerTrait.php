<?php

namespace App\Exceptions;

use App\Helpers\ResponseObject;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait JsonExceptionHandlerTrait
{
    /**
     * Render exceptions for api.
     *
     * @param  Illuminate\Http\Request     $request
     * @param  \Throwable                  $exception
     * @return \Illuminate\Http\Response
     */
    public function apiException($request, Throwable $exception)
    {
        $response = new ResponseObject();
        if($exception instanceof BadRequestException){
            $response->errors = ['message' => $exception->getBadRequestMassege()];
            $response->statusCode = Response::HTTP_BAD_REQUEST;
        }
        elseif ($exception instanceof ModelNotFoundException)
        {
            $modelName = substr($exception->getModel(), (strrpos($exception->getModel(),'\\') + 1));
            $response->errors = ['message' => 'You try to get model ('.$modelName.') by wrong id.'];
            $response->statusCode = Response::HTTP_NOT_FOUND;
        }
        elseif($exception instanceof AuthorizationException)
        {
            $response->errors = ['message' => 'This action is unauthorized'];
            $response->statusCode = Response::HTTP_FORBIDDEN;
        }
        elseif($exception instanceof ValidationException)
        {
            $errorMessages = [];
            foreach ($exception->validator->errors()->getMessages() as $parameter => $messages)
                $errorMessages[$parameter] = $messages;
            $response->errors = $errorMessages;
            $response->statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }
        elseif ($exception instanceof HttpException) {
            $response->errors = ['message' => $exception->getMessage()];
            $response->statusCode = Response::HTTP_NOT_FOUND;
        }
        elseif ($exception instanceof RequestException) {
            $response->errors = ['message' => $exception->getMessage()];
            $response->statusCode = Response::HTTP_NOT_FOUND;
        }
        elseif ($exception instanceof CustomException) {
            $response->errors = ['message' => $exception->getCustomMassege()];
            $response->statusCode = $exception->getStatusCode();
        }
        elseif ($exception instanceof AuthenticationException) {
            $response->errors = ['message' => $exception->getMessage()];
            $response->statusCode = Response::HTTP_FORBIDDEN;
        }
        elseif ($exception instanceof AuthorizationException) {
            $response->errors = ['message' => $exception->getMessage()];
            $response->statusCode = Response::HTTP_UNAUTHORIZED;
        }
        else{
            if(App::environment('local', 'staging')) {
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

            } else {
                $response->errors = trans('system.fail');
                $response->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            }
        }
        return response()->json($response,$response->statusCode);
    }
}
