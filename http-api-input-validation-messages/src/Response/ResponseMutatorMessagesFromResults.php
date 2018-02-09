<?php

namespace Zrcms\HttpApiInputValidationMessages\Api\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Http\Api\IsValidContentType;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRatMessages\Api\GetMessagesValidationResult;
use Reliv\ValidationRatMessages\Api\GetMessagesValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorMessagesFromResults
{
    protected $getMessagesValidationResult;
    protected $getMessagesValidationResultFields;
    protected $validContentTypes;

    /**
     * @param GetMessagesValidationResult       $getMessagesValidationResult
     * @param GetMessagesValidationResultFields $getMessagesValidationResultFields
     * @param array                             $validContentTypes
     */
    public function __construct(
        GetMessagesValidationResult $getMessagesValidationResult,
        GetMessagesValidationResultFields $getMessagesValidationResultFields,
        array $validContentTypes = ['application/json', 'json']
    ) {
        $this->getMessagesValidationResult = $getMessagesValidationResult;
        $this->getMessagesValidationResultFields = $getMessagesValidationResultFields;
        $this->validContentTypes = $validContentTypes;
    }

    /**
     * @param ServerRequestInterface                           $request
     * @param ResponseInterface|JsonResponse|ZrcmsJsonResponse $response
     * @param callable|null                                    $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        /** @var ZrcmsJsonResponse $response */
        $response = $next($request, $response);

        if (!$this->canHandleResponse($response)) {
            return $response;
        }

        $options = [];

        if (!method_exists($response, 'getOptions')) {
            $options = $response->getOptions();
        }

        /** @var ValidationResult|ValidationResultFields $apiMessages */
        $apiMessages = $response->getApiMessages();

        if ($apiMessages instanceof ValidationResultFields) {
            return $response->withApiMessages(
                $this->getMessagesValidationResultFields->__invoke(
                    $apiMessages,
                    $options
                )
            );
        }

        if ($apiMessages instanceof ValidationResult) {
            return $response->withApiMessages(
                $this->getMessagesValidationResult->__invoke(
                    $apiMessages,
                    $options
                )
            );
        }

        return $response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return bool
     */
    protected function canHandleResponse(
        ResponseInterface $response
    ): bool {
        if ($response instanceof ZrcmsJsonResponse) {
            return true;
        }

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
