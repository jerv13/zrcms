<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseWithExceptionMessage implements HandleResponse
{
    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return HtmlResponse
     * @throws CanNotHandleResponse
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    ) {
        $exception = Param::get(
            $options,
            HandleResponseOptions::EXCEPTION
        );

        $this->assertCanHandleResponse($exception);

        return new HtmlResponse(
            $exception->getMessage(),
            $response->getStatusCode(),
            $response->getHeaders()
        );
    }

    /**
     * @param \Exception|null $exception
     *
     * @return void
     * @throws CanNotHandleResponse
     */
    public function assertCanHandleResponse(
        $exception
    ) {
        if ($exception instanceof \Exception) {
            return;
        }

        throw new CanNotHandleResponse();
    }
}
