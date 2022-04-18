<?php


namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class BaseController extends Controller
{
    public function failed($message, array $data = []): JsonResponse
    {
        $response = [
            'status' => false,
            'code' => 400,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, 400);
    }

    public function notFound($message, array $data = []): JsonResponse
    {
        $response = [
            'status' => false,
            'code' => 404,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, 404);
    }

    public function forbidden($message = "Forbidden", array $data = []): JsonResponse
    {
        $response = [
            'status' => false,
            'code' => 403,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, 403);
    }

    public function success($data, $message = "success"): JsonResponse
    {
        $response = [
            'status' => true,
            'code' => 200,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response);
    }

    public function storeMediaFiles($model, $filename, $keyName)
    {
        if ($model && $filename && $keyName){
            $model->addMedia(storage_path('tmp/uploads/' . basename($filename)))->toMediaCollection($keyName);
        }
    }

    public function updateMediaFiles($model, $filename, $keyName)
    {
        if ($model && $filename && $keyName){
            if ($filename) {
                if (!$model->$keyName || $filename !== $model->$keyName->file_name) {
                    if ($model->$keyName) {
                        $model->$keyName->delete();
                    }
                    $model->addMedia(storage_path('tmp/uploads/' . basename($filename)))->toMediaCollection($keyName);
                }
            } elseif ($model->$keyName) {
                $model->$keyName->delete();
            }
        }
    }
}
