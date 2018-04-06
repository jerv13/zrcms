<?php

namespace Zrcms\HttpApiInputValidationMessages\Response;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRatMessages\Api\GetMessagesValidationResult;
use Reliv\ValidationRatMessages\Api\GetMessagesValidationResultFields;
use Reliv\ValidationRatMessages\Api\GetMessagesValidationResultFieldsByOption;
use Zrcms\Http\Api\IsValidContentType;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorMessagesFromResults implements MiddlewareInterface
{
    const PARAM_MESSAGES_FORMAT = 'validationMessagesFormat';

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

        $options = [];

        if (method_exists($response, 'getOptions')) {
            $options = $response->getOptions();
        }

        $queryParams = $request->getQueryParams();

        $validationMessagesFormat = Property::getString(
            $queryParams,
            self::PARAM_MESSAGES_FORMAT
        );

        if (!empty($validationMessagesFormat)) {
            $options[GetMessagesValidationResultFieldsByOption::OPTION_FORMAT] = $validationMessagesFormat;
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
