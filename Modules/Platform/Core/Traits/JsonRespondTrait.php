<?php

namespace Modules\Platform\Core\Traits;

/**
 * Trait JsonRespondTrait
 * @package Modules\Platform\Core\Traits
 */
trait JsonRespondTrait
{

    /**
     * Respond with message
     *
     * @param string $message
     * @param $data
     * @param bool $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($message = '', $status = true, $data = [])
    {

        return response()->json(['message' => $message, 'data' => $data, 'status' => $status], $status ? 200 : 201);
    }

}