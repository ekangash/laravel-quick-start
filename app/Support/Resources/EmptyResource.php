<?php

namespace App\Support\Resources;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EmptyResource
 *
 * @package App\Support\Resources
 */
class EmptyResource implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return Response
     */
    public function toResponse($request): Response
    {
        return response()->json(['data' => null]);
    }
}
