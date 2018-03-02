<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ArrayProperties\Property;

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

        $validateConfig = Property::getArray(
            $dynamicApiConfig,
            Dynamic::MIDDLEWARE_NAME_FIELDS_VALIDATOR,
            []
        );

        $validateServiceName = Property::getString(
            $validateConfig,
            'fields-validator'
        );

        if (!$this->serviceContainer->has($validateServiceName)) {
            throw new \Exception(
                'fields-validator must be a service: (' . $validateServiceName . ')'
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

        $validateOptions = Property::getArray(
            $validateConfig,
            'fields-validator-options',
            []
        );

        $data = $request->getParsedBody();

        $validationResult = $validate->__invoke(
            $data,
            $validateOptions
        );

        if (!$validationResult->isValid()) {
            $notValidStatus = Property::getInt(
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
