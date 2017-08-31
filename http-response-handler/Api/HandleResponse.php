<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HandleResponse
{
    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return ResponseInterface
     * @throws CanNotHandleResponse
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    );
}
