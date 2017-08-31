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
class HandleResponseApiMessages implements HandleResponseApi
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
     * @param ResponseInterface|JsonResponse $response
     * @param array                          $options
     *
     * @return ApiResponseInterface|PsrApiResponse
     * @throws CanNotHandleResponse
     */
    public function __invoke(
        ResponseInterface $response,
        array $options = []
    ) {
        $this->assertCanHandleResponse($response, $options);

        $apiMessagesData = Param::get(
            $options,
            HandleResponseOptions::API_MESSAGES,
            null
        );

        $data = $response->getPayload();

        return $this->psrResponseService->getPsrApiResponse(
            $response,
            $data,
            $response->getStatusCode(),
            $apiMessagesData
        );
    }

    /**
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return void
     * @throws CanNotHandleResponse
     */
    protected function assertCanHandleResponse(
        ResponseInterface $response,
        array $options = []
    ) {
        if (!method_exists($response, 'getPayload')) {
            return;
        }

        if ($response instanceof JsonResponse) {
            return;
        }

        throw new CanNotHandleResponse();
    }
}
