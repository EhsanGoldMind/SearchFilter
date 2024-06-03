<?php

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;



function responseError($response): array
{
    return [
        'success' => array_key_exists('success', $response) ? $response['success'] : false,
        'data' => array_key_exists('data', $response) ? $response['data'] : null,
        'errors' => array_key_exists('errors', $response) ? [$response['errors']] : null,
        'message' => array_key_exists('message', $response) ? $response['message'] : "ارسال درخواست با خطا مواجه شد"
    ];
}


function error($message = "اطلاعات وارد شده صحیح نمی باشد.", $status = 422): array
{
    $error['status'] = $status;
    $error['errors']['error'] = $message;
    $error['success'] = false;
    $error['message'] = $message;
    return $error;
}
function perPage()
{
    $req = request();
    return min(500, max(10, intval($req['perpage'])));
}
function ResponseOK($response = null, $message = 'درخواست شما با موفقیت انجام شد')
{
    if (!$response){
        return response()->json([
            'data' => null,
            'success' => true,
            'errors' => null,
            'message' => $message,
        ]);
    }
    return ($response)->additional([
        'success' => true,
        'errors' => null,
        'message' => $message,
    ]);
}
function failValidate($validator): JsonResponse
{
    return response()->json(
        [
            'success' => false,
            'data' => null,
            'errors' => $validator->errors(),
            'message' => $validator->errors()->first()
        ], Response::HTTP_UNPROCESSABLE_ENTITY
    );
}
