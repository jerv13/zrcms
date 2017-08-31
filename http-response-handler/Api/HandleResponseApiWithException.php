<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Reliv\RcmApiLib\Http\ApiResponseInterface;
use Reliv\RcmApiLib\Http\PsrApiResponse;
use Reliv\RcmApiLib\Service\PsrResponseService;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\HttpResponseHandler\Exception\CanNotHandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseApiWithException implements HandleResponseApi
{
    /**
     * @var PsrResponseService
     */
    protected $psrResponseService;

    /**
     * @param PsrResponseService $psrResponseService
     */
    public function __construct(
        PsrResponseService $psrResponseService
    ) {
        $this->psrResponseService = $psrResponseService;
    }

    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return ApiResponseInterface|PsrApiResponse
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

        $this->assertCanHandleResponse($response, $exception);

        $data = null;

        $data = Param::get(
            $options,
            HandleResponseOptions::DATA,
            $data
        );

        return $this->psrResponseService->getPsrApiResponse(
            $response,
            $data,
            $response->getStatusCode(),
            $exception
        );
    }

    /**
     * @param ResponseInterface $response
     * @param \Exception|null   $exception
     *
     * @return void
     * @throws CanNotHandleResponse
     */
    protected function assertCanHandleResponse(
        ResponseInterface $response,
        $exception
    ) {
        if (!method_exists($response, 'getPayload')) {
            return;
        }

        if ($response instanceof JsonResponse) {
            return;
        }

        if ($exception instanceof \Exception) {
            return;
        }

        throw new CanNotHandleResponse();
    }
}
