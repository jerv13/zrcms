<?php

namespace Zrcms\HttpApi\Validate;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateFields implements MiddlewareInterface
{
    const FIELDS_VALIDATOR = 'fields-validator';
    const FIELDS_VALIDATOR_OPTIONS = 'fields-validator-options';

    protected $validateFields;
    protected $validateFieldsOptions;
    protected $notValidStatus;
    protected $debug;

    /**
     * @param ValidateFields $validateFields
     * @param array          $validateFieldsOptions
     * @param int            $notValidStatus
     * @param bool           $debug
     */
    public function __construct(
        ValidateFields $validateFields,
        array $validateFieldsOptions,
        int $notValidStatus = 400,
        bool $debug = false
    ) {
        $this->validateFields = $validateFields;
        $this->validateFieldsOptions = $validateFieldsOptions;
        $this->notValidStatus = $notValidStatus;
        $this->debug = $debug;
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
        $data = $request->getParsedBody();

        $validationResult = $this->validateFields->__invoke(
            $data,
            $this->validateFieldsOptions
        );

        if (!$validationResult->isValid()) {
            return new ZrcmsJsonResponse(
                null,
                $validationResult,
                $this->notValidStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        return $delegate->process($request);
    }
}
