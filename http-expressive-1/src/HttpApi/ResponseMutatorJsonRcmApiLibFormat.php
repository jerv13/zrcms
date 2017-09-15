<?php

namespace Zrcms\HttpExpressive1\HttpApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\RcmApiLib\Service\PsrResponseService;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\HttpExpressive1\Api\IsValidContentType;
use Zrcms\HttpExpressive1\Model\JsonApiResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorJsonRcmApiLibFormat
{
    /**
     * @var PsrResponseService
     */
    protected $psrResponseService;

    /**
     * @var array
     */
    protected $validContentTypes;

    /**
     * @param PsrResponseService $psrResponseService
     * @param array              $validContentTypes
     */
    public function __construct(
        PsrResponseService $psrResponseService,
        array $validContentTypes = ['application/json', 'json']
    ) {
        $this->psrResponseService = $psrResponseService;
        $this->validContentTypes = $validContentTypes;
    }

    /**
     * @param ServerRequestInterface         $request
     * @param ResponseInterface|JsonResponse $response
     * @param callable|null                  $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        /** @var JsonApiResponse $response */
        $response = $next($request, $response);

        if (!$this->canHandleResponse($response)) {
            return $response;
        }

        $data = $response->getPayload();

        $apiMessagesData = $response->getApiMessages();

        return $this->psrResponseService->getPsrApiResponse(
            $response,
            $data,
            $response->getStatusCode(),
            $apiMessagesData
        );
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ResponseInterface $response
    ):bool
    {
        if (!IsValidContentType::invoke($response, $this->validContentTypes)) {
            return false;
        }

        if (!method_exists($response, 'getPayload')) {
            return false;
        }

        if (!method_exists($response, 'getApiMessages')) {
            return false;
        }

        return true;
    }
}