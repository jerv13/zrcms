<?php

namespace Zrcms\HttpApi\Dynamic;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Zrcms\HttpApi\DynamicApiConfigNotFound;
use Zrcms\HttpApi\GetDynamicApiConfig;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiDynamic
{
    const SOURCE = 'http-api-dynamic';

    protected $getRouteOptions;
    protected $getDynamicApiConfig;
    protected $notImplementedStatus;
    protected $debug;

    /**
     * @param GetRouteOptions     $getRouteOptions
     * @param GetDynamicApiConfig $getDynamicApiConfig
     * @param int                 $notImplementedStatus
     * @param bool                $debug
     */
    public function __construct(
        GetRouteOptions $getRouteOptions,
        GetDynamicApiConfig $getDynamicApiConfig,
        int $notImplementedStatus = 405,
        bool $debug = false
    ) {
        $this->getRouteOptions = $getRouteOptions;
        $this->getDynamicApiConfig = $getDynamicApiConfig;
        $this->notImplementedStatus = $notImplementedStatus;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $routeOptions = $this->getRouteOptions->__invoke($request);

        $zrcmsApiName = Property::getRequired(
            $routeOptions,
            Dynamic::ROUTE_OPTION_ZRCMS_API
        );

        $zrcmsImplementation = $request->getAttribute(Dynamic::ATTRIBUTE_ZRCMS_IMPLEMENTATION);

        $dynamicApiType = $zrcmsImplementation . ':' . $zrcmsApiName;

        try {
            $dynamicApiConfig = $this->getDynamicApiConfig->__invoke(
                $zrcmsImplementation,
                $zrcmsApiName
            );
        } catch (DynamicApiConfigNotFound $exception) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->notImplementedStatus,
                    'Not Implemented',
                    $dynamicApiType,
                    self::SOURCE
                ),
                $this->notImplementedStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        return $next(
            $request->withAttribute(
                Dynamic::ATTRIBUTE_DYNAMIC_API_CONFIG,
                $dynamicApiConfig
            )->withAttribute(
                Dynamic::ATTRIBUTE_ZRCMS_API,
                $zrcmsApiName
            )->withAttribute(
                Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE,
                $dynamicApiType
            ),
            $response
        );
    }
}
