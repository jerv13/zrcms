<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseWithExceptionMessage
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $options
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
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
