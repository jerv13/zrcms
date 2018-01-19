<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\GetDynamicApiValue;
use Zrcms\HttpApi\HttpApiDynamic;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Api\ValidateId;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateIdAttributeDynamic implements HttpApiDynamic
{
    const SOURCE = 'http-api-validate-id-attribute-dynamic';

    protected $serviceContainer;
    protected $getRouteOptions;
    protected $getDynamicApiValue;
    protected $validateIdDefault;
    protected $notValidStatusDefault;
    protected $debug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param GetRouteOptions    $getRouteOptions
     * @param GetDynamicApiValue $getDynamicApiValue
     * @param ValidateId         $validateIdDefault
     * @param int                $notValidStatusDefault
     * @param bool               $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetRouteOptions $getRouteOptions,
        GetDynamicApiValue $getDynamicApiValue,
        ValidateId $validateIdDefault,
        int $notValidStatusDefault = 400,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getRouteOptions = $getRouteOptions;
        $this->getDynamicApiValue = $getDynamicApiValue;
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
        $routeOptions = $this->getRouteOptions->__invoke($request);

        $zrcmsApiName = Param::getRequired(
            $routeOptions,
            static::ROUTE_OPTION_ZRCMS_API
        );

        $zrcmsImplementation = $request->getAttribute(static::ATTRIBUTE_ZRCMS_IMPLEMENTATION);

        $validateConfig = $this->getDynamicApiValue->__invoke(
            $zrcmsImplementation,
            $zrcmsApiName,
            static::MIDDLEWARE_NAME_VALIDATE_ID,
            []
        );

        $validateServiceName = Param::getString(
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

        $validateOptions = Param::getArray(
            $validateConfig,
            'validate-options',
            []
        );

        $httpApiId = $request->getAttribute(static::ATTRIBUTE_ZRCMS_ID);

        $validationResult = $validateService->__invoke(
            $httpApiId,
            $validateOptions
        );

        if (!$validationResult->isValid()) {
            $notValidStatusDefault = Param::getInt(
                $validateOptions,
                'not-valid-status',
                $this->notValidStatusDefault
            );

            $apiMessages = [
                'type' => $zrcmsImplementation . ':' . $zrcmsApiName,
                'message' => 'Not Valid',
                'source' => self::SOURCE,
                'code' => $validationResult->getCode(),
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $notValidStatusDefault
            );
        }

        return $next($request, $response);
    }
}
