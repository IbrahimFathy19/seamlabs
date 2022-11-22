<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseObject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function handleResponse($data)
    {
        $response = new ResponseObject();
        $response->object = $data;
        $response->status_code = Response::HTTP_OK;
        return response()->json($response, $response->status_code);
    }

    public function handleCreated($message)
    {
        $response = new ResponseObject();
        $response->object = $message;
        $response->status_code = Response::HTTP_CREATED;
        return response()->json($response, $response->status_code);
    }

    public function handleResponseError($message, $status_code = null)
    {
        $response = new ResponseObject();
        $response->errors = ['message' => $message];
        $response->status_code = $status_code ?? Response::HTTP_BAD_REQUEST;
        return response()->json($response, $response->status_code);
    }

    public function handleValidationError($data)
    {
        $response = new ResponseObject();
        $response->errors = $data;
        $response->status_code = Response::HTTP_BAD_REQUEST;
        return response()->json($response, $response->status_code);
    }
}
