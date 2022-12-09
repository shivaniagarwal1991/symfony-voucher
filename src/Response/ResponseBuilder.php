<?php
namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseBuilder
{
    public static function noContent(?string $message = null): JsonResponse
    {
       return self::buildResponse(Response::HTTP_NO_CONTENT,  $message);
    }

    public static function ok(?string $message = null, ?array $data = []) : JsonResponse
    {
        return self::buildResponse(Response::HTTP_OK,  $message, $data);
    }

    public static function created(?array $data = []): JsonResponse
    {
        return self::buildResponse(Response::HTTP_CREATED,null, $data);
    }

    private static function buildResponse(int $status, ?string $message = null, ?array $data =[]): JsonResponse
    {
        $arr = ["code" => $status];

        if(!empty($message)) {
            $arr['message'] = $message;
        }
        if(!empty($data)) {
            $arr['data'] = $data;
        }
        return new JsonResponse($arr);
    }
}