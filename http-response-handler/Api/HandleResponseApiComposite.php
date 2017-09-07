<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseApiComposite implements HandleResponseApi
{
    /**
     * @var array
     */
    protected $responseHandlers = [];

    /**
     * @param HandleResponseApi[]|\Traversable $responseHandlers
     */
    public function __construct(
        $responseHandlers
    ) {
        foreach ($responseHandlers as $responseHandler) {
            $this->add($responseHandler);
        }
    }

    /**
     * @param HandleResponseApi $responseHandler
     *
     * @return void
     */
    protected function add(
        HandleResponseApi $responseHandler
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
        /** @var HandleResponseApi $responseHandler */
        foreach ($this->responseHandlers as $responseHandler) {
            try {
                $handledResponse = $responseHandler->__invoke(
                    $response,
                    $options
                );
            } catch (CanNotHandleResponse $exception) {
                continue;
            }

            return $handledResponse->withAddedHeader(
                'zrcms-response-handler',
                get_class($responseHandler)
            );
        }

        throw new CanNotHandleResponse('No handlers can handle response');
    }
}
