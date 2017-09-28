<?php

namespace Zrcms\HttpExpressive1\HttpApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\RcmApiLib\Api\ApiResponse\NewPsrResponseWithTranslatedMessages;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\HttpExpressive1\Api\IsValidContentType;
use Zrcms\HttpExpressive1\Http\JsonApiResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorJsonRcmApiLibFormat
{
    /**
     * @var NewPsrResponseWithTranslatedMessages
     */
    protected $newPsrResponseWithTranslatedMessages;

    /**
     * @var array
     */
    protected $validContentTypes;

    /**
     * @param NewPsrResponseWithTranslatedMessages $newPsrResponseWithTranslatedMessages
     * @param array              $validContentTypes
     */
    public function __construct(
        NewPsrResponseWithTranslatedMessages $newPsrResponseWithTranslatedMessages,
        array $validContentTypes = ['application/json', 'json']
    ) {
        $this->newPsrResponseWithTranslatedMessages = $newPsrResponseWithTranslatedMessages;
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

        return $this->newPsrResponseWithTranslatedMessages->__invoke(
            $data,
            $response->getStatusCode(),
            $apiMessagesData,
            $response->getHeaders()
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
