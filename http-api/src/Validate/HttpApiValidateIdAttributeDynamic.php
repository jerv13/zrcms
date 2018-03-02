<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Reliv\ValidationRat\Api\Validator\Validate;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateId;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateIdAttributeDynamic
{
    const SOURCE = 'http-api-validate-id-attribute-dynamic';

    protected $serviceContainer;
    protected $validateIdDefault;
    protected $notValidStatusDefault;
    protected $debug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param ValidateId         $validateIdDefault
     * @param int                $notValidStatusDefault
     * @param bool               $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        ValidateId $validateIdDefault,
        int $notValidStatusDefault = 400,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->validateIdDefault = $validateIdDefault;
        $this->notValidStatusDefault = $notValidStatusDefault;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface|ZrcmsJsonResponse
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $dynamicApiConfig = $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_CONFIG);

        $validateConfig = Property::getArray(
            $dynamicApiConfig,
            Dynamic::MIDDLEWARE_NAME_VALIDATE_ID,
            []
        );

        $validateServiceName = Property::getString(
            $validateConfig,
            'validate',
            null
        );

        if ($validateServiceName === null) {
            throw new \Exception('validate-id must be defined');
        }

        /** @var Validate $validateService */
        $validateService = $this->serviceContainer->get($validateServiceName);

        if (!$validateService instanceof Validate) {
            throw new \Exception(
                'validate id must be instance of ' . ValidateId::class
                . ' got .' . get_class($validateService)
            );
        }

        $validateOptions = Property::getArray(
            $validateConfig,
            'validate-options',
            []
        );

        $httpApiId = $request->getAttribute(Dynamic::ATTRIBUTE_ZRCMS_ID);

        $validationResult = $validateService->__invoke(
            $httpApiId,
            $validateOptions
        );

        if (!$validationResult->isValid()) {
            $notValidStatusDefault = Property::getInt(
                $validateOptions,
                'not-valid-status',
                $this->notValidStatusDefault
            );

            return new ZrcmsJsonResponse(
                null,
                $validationResult,
                $notValidStatusDefault,
                [],
                BuildResponseOptions::invoke()
            );
        }

        return $next($request, $response);
    }
}
