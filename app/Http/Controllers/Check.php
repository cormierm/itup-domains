<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckRequest;
use Illuminate\Http\JsonResponse;

class Check
{
    public function __invoke(CheckRequest $request): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Congrats, This hostname is available!'
        ]);
    }
}
