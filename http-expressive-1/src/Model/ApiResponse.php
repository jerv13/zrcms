<?php

namespace Zrcms\HttpExpressive1\Model;

use Reliv\RcmApiLib\Http\PsrApiResponse;

/**
 * @deprecated Use JsonResponse and HandleResponseApi
 * @author James Jervis - https://github.com/jerv13
 */
class ApiResponse extends PsrApiResponse
{
    public function __construct(
        $data,
        array $apiMessages,
        $status,
        array $headers,
        $encodingOptions
    ) {
        parent::__construct(
            $data,
            $apiMessages,
            $status,
            $headers,
            $encodingOptions
        );
    }
}
