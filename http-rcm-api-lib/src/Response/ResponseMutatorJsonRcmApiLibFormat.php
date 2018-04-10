<?php

namespace Zrcms\HttpRcmApiLib\Response;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\RcmApiLib\Api\ApiResponse\NewPsrResponseWithTranslatedMessages;
use Reliv\RcmApiLib\Exception\CanNotHydrate;
use Reliv\RcmApiLib\Http\PsrApiResponse;
use Zrcms\Http\Api\IsValidContentType;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorJsonRcmApiLibFormat implements MiddlewareInterface
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
     * @param array                                $validContentTypes
     */
    public function __construct(
        NewPsrResponseWithTranslatedMessages $newPsrResponseWithTranslatedMessages,
        array $validContentTypes = ['application/json', 'json']
    ) {
        $this->newPsrResponseWithTranslatedMessages = $newPsrResponseWithTranslatedMessages;
        $this->validContentTypes = $validContentTypes;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|ZrcmsJsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        /** @var ZrcmsJsonResponse $response */
        $response = $delegate->process($request);

        if (!$this->canHandleResponse($response)) {
            return $response;
        }

        $data = $response->getPayload();

        $apiMessageData = $response->getApiMessages();

        try {
            $apiResponse = $this->newPsrResponseWithTranslatedMessages->__invoke(
                $data,
                $response->getStatusCode(),
                $apiMessageData,
                $response->getHeaders(),
                $this->buildOptions([], $response)
            );
        } catch (CanNotHydrate $exception) {
            // do nothing
            $apiResponse = $response;
        }

        return $apiResponse;
    }

    /**
     * @param array             $options
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function buildOptions(
        array $options,
        ResponseInterface $response
    ): array {
        if (method_exists($response, 'getEncodingOptions')) {
            $options[NewPsrResponseWithTranslatedMessages::OPTIONS_ENCODING] = $response->getEncodingOptions();
        }

        return $options;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ResponseInterface $response
    ): bool {
        if (!IsValidContentType::invoke($response, $this->validContentTypes)) {
            return false;
        }

        if (!method_exists($response, 'getPayload')) {
            return false;
        }

        if (!method_exists($response, 'getApiMessages')) {
            return false;
        }

        if ($response instanceof PsrApiResponse) {
            // @todo might translate and hydrate these here,
            // @todo but it is likely they were translated and hydrated before
            return false;
        }

        return true;
    }
}
