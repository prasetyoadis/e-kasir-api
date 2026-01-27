<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseApiController extends Controller
{
    /**
     * Protected function for return failed internal server error.
     * 
     * @param string $message
     * @param string $errorCode
     * @param string $errorMessage
     * @return Illuminate\Http\JsonResponse
     */
    protected function failedInternalServerError(
        string $message,
        string $errorCode,
        string $errorMessage,
        int $code = 500
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'Unexpected server error',
            'statusDescription' => $message,
            'result' => [
                'errorCode' => $errorCode,
                'errorMessage' => $errorMessage
            ]
        ], $code);
    }

    /**
     * Protected function for return failed unauthorized.
     * 
     * @param string $message
     * @param string $errorCode
     * @param string $errorMessage
     * @return Illuminate\Http\JsonResponse
     */
    protected function failedUnauthorized(
        string $message,
        string $errorCode,
        string $errorMessage,
        int $code = 401
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'Unauthorized',
            'statusDescription' => $message,
            'result' => [
                'errorCode' => $errorCode,
                'errorMessage' => $errorMessage
            ]
        ], $code);
    }
    
    /**
     * Protected function for return failed not found.
     * 
     * @param string $message
     * @return Illuminate\Http\JsonResponse
     */
    protected function failedNotFound(
        string $message,
        int $code = 404
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'Not Found',
            'statusDescription' => $message,
            'result' => [
                'errorCode' => '28',
                'errorMessage' => 'Data not found'
            ]
        ], $code);
    }

    /**
     * Protected function for return success get single data.
     * 
     * @param mixed $dataToken
     * @param mixed $dataUser
     * @return Illuminate\Http\JsonResponse
     */
    protected function successLogin(
        mixed $dataToken,
        mixed $dataUser,
        int $code = 200
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'OK',
            'statusDescription' => 'Request processed successfully',
            'result' => [
                'successMessage' => 'Log in successfully',
                'data' => [
                    'token' => $dataToken,
                    'user' => $dataUser
                ]
            ]
        ], $code);
    }

    /**
     * Protected function for return success get single data.
     * 
     * @param string $message
     * @param mixed $data
     * @return Illuminate\Http\JsonResponse
     */
    protected function successLogout(
        int $code = 200
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => "OK",
            'statusDescription' => 'Request processed successfully',
            'result' => [
                'successMessage' => 'Log out successfully',
            ]
        ], $code);
    }
    /**
     * Protected function for return success get single data.
     * 
     * @param string $message
     * @param mixed $data
     * @return Illuminate\Http\JsonResponse
     */
    protected function successGetData(
        string $message,
        mixed $data,
        int $code = 200
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'OK',
            'statusDescription' => 'Request processed successfully',
            'result' => [
                'data' => $data,
            ]
        ], $code);
    }

    /**
     * Protected function for return success get data with pagination.
     * 
     * @param string $message
     * @param mixed $data
     * @param Illuminate\Pagination\LengthAwarePaginator $paginator
     * @return Illuminate\Http\JsonResponse
     */
    protected function successPaginated(
        string $message,
        mixed $data,
        LengthAwarePaginator $paginator,
        int $code = 200
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'OK',
            'statusDescription' => $message,
            'result' => [
                'data' => $data,
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'last_page' => $paginator->lastPage()
                ]
            ]
        ], $code);
    }

    /**
     * Protected function for return success created data.
     * 
     * @param string $message
     * @param mixed $data
     * @return Illuminate\Http\JsonResponse
     */
    protected function successCreateData(
        string $message,
        mixed $data,
        int $code = 201
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'Created',
            'statusDescription' => 'Resource created successfully',
            'result' => [
                'successMessage' => $message,
                'data' => $data,
            ]
        ], $code);
    }

    /**
     * Protected function for return success updated data.
     * 
     * @param string $message
     * @param mixed $data
     * @return Illuminate\Http\JsonResponse
     */
    protected function successUpdateData(
        string $message,
        string $id,
        int $code = 200
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'OK',
            'statusDescription' => 'Resource updated successfully',
            'result' => [
                'successMessage' => $message,
                'data' => [
                    'id' => $id
                ],
            ]
        ], $code);
    }

    /**
     * Protected function for return success updated data.
     * 
     * @param string $message
     * @param mixed $data
     * @return Illuminate\Http\JsonResponse
     */
    protected function successSoftDeleteData(
        string $message,
        string $id,
        int $code = 200
    ): JsonResponse{
        return response()->json([
            'statusCode' => $code,
            'statusMessage' => 'OK',
            'statusDescription' => 'Resource soft deleted successfully',
            'result' => [
                'successMessage' => $message,
                'data' => [
                    'id' => $id
                ],
            ]
        ], $code);
    }
}
