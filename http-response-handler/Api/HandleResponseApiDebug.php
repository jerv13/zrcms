<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseApiDebug implements HandleResponseApi
{
    /**
     * @var bool
     */
    protected $debug;

    /**
     * @param bool $debug
     */
    public function __construct(
        $debug = false
    ) {
        $this->debug = $debug;
    }

    /**
     * @param JsonResponse|ResponseInterface $response
     * @param array             $options
     *
     * @return ResponseInterface|HtmlResponse
     * @throws CanNotHandleResponse
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    ) {
        $message = Param::get(
            $options,
            HandleResponseOptions::MESSAGE,
            ''
        );

        $this->assertCanHandleResponse($response, $message);

        $payLoad = $response->getPayload();

        if(is_a($payLoad, \JsonSerializable::class)) {
            $payLoad = $payLoad->jsonSerialize();
        }

        if(is_array($payLoad)) {
            $payLoad['zrcms-debug'] = $message;
        }

        return new JsonResponse(
            $payLoad,
            $response->getStatusCode(),
            $response->getHeaders()
        );
    }

    /**
     * @param ResponseInterface $response
     * @param string            $message
     *
     * @return void
     * @throws CanNotHandleResponse
     */
    public function assertCanHandleResponse(
        ResponseInterface $response,
        $message
    ) {
        if (!method_exists($response, 'getPayload')) {
            return;
        }

        if ($response instanceof JsonResponse) {
            return;
        }

        if ($this->debug && !empty($message)) {
            return;
        }

        throw new CanNotHandleResponse();
    }
}
