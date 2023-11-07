<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;


class BaseController extends Controller

{

    /*
     * success response method.
     * @return \Illuminate\Http\Response
    */

    public function sendResponse(array $result, string $message) : JsonResponse
    {

    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    /*
     * return error response.
     * @return \Illuminate\Http\Response
    */

    public function sendError(string $error, Array $errorMessages = [], int $code = 404) : JsonResponse
    {

    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)) $response['data'] = $errorMessages;
        return response()->json($response, $code);

    }

}
