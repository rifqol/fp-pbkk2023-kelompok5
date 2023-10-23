<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Psy\Exception\TypeErrorException;
use Throwable;
use TypeError;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function executeService($service)
    {
        try {
            $data = $service();
            return $this->success($data);
        } catch (Throwable $error) {
            return $this->fail($error->getMessage(), 500);
        }
    }

    public function success($data, $code = 200) {
        return response()->json([
            'status' => 'Request success',
            'data' => $data
        ], $code);
    }

    public function fail($data = null, $code) {
        return response()->json([
            'status' => 'Request failed',
            'error' => $data
        ], $code);
    }
}
