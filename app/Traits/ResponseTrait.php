<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public function jsonResponse(int $success, string $message, array $data = null): JsonResponse
    {
        $res['success'] = $success;
        $res['message'] = $message;
        $res['data']    = $data;

        return response()->json($res);
    }

    public function modalResponse(string $title, string $view, array $data = null): JsonResponse
    {
        $res['title'] = $title;
        $res['html'] = view($view, empty($data) ? [] : $data)->render();

        return response()->json($res);
    }
}
