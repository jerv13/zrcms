<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseComposite implements HandleResponse, HandleResponseApi
{
    /**
     * @var array
     */
    protected $responseHandlers = [];

    /**
     * @param HandleResponse[]|\Traversable $responseHandlers
     */
    public function __construct(
        $responseHandlers
    ) {
        foreach ($responseHandlers as $responseHandler) {
            $this->add($responseHandler);
        }
    }

    /**
     * @param HandleResponse $responseHandler
     *
     * @return void
     */
    protected function add(
        HandleResponse $responseHandler
    ) {
        $this->responseHandlers[] = $responseHandler;
    }

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
    ) {
        /** @var HandleResponse $responseHandler */
        foreach ($this->responseHandlers as $responseHandler) {
            try {
                $handledResponse = $responseHandler->__invoke(
                    $response,
                    $options
                );
            } catch (CanNotHandleResponse $exception) {
                continue;
            }

            return $handledResponse;
        }

        throw new CanNotHandleResponse('No handlers can handle response');
    }
}
