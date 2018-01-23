<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateFieldsDynamic
{
    const SOURCE = 'http-api-validate-fields-dynamic';

    protected $serviceContainer;
    protected $notValidStatusDefault;
    protected $debug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param int                $notValidStatusDefault
     * @param bool               $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        int $notValidStatusDefault = 400,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
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

        $validateConfig = Param::getArray(
            $dynamicApiConfig,
            Dynamic::MIDDLEWARE_NAME_VALIDATE_FIELDS,
            []
        );

        $validateServiceName = Param::getString(
            $validateConfig,
            'validate-fields'
        );

        if (!$this->serviceContainer->has($validateServiceName)) {
            throw new \Exception(
                'validate-fields must be a service: (' . $validateServiceName . ')'
            );
        }

        $validate = $this->serviceContainer->get($validateServiceName);

        if (!$validate instanceof ValidateFields) {
            throw new \Exception(
                'Validate must be instance of ' . ValidateFields::class
                . ' got (' . get_class($validate) . ')'
                . ' for dynamic api: (' . $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE) . ')'
            );
        }

        $validateOptions = Param::getArray(
            $validateConfig,
            'validate-fields-options',
            []
        );

        $data = $request->getParsedBody();

        $validationResult = $validate->__invoke(
            $data,
            $validateOptions
        );

        if (!$validationResult->isValid()) {
            $notValidStatus = Param::getInt(
                $validateConfig,
                'not-valid-status',
                $this->notValidStatusDefault
            );

            return new ZrcmsJsonResponse(
                null,
                $validationResult,
                $notValidStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        return $next($request, $response);
    }
}
