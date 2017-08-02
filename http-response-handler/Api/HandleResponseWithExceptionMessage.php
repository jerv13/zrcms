<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseWithExceptionMessage
{
    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    ): ResponseInterface
    {
        $exception = Param::get(
            $options,
            HandleResponseOptions::EXCEPTION
        );

        if ($exception instanceof \Exception) {
            return new HtmlResponse(
                $exception->getMessage(),
                $response->getStatusCode(),
                $response->getHeaders()
            );
        }

        return $response;
    }
}
