<?php

namespace Zrcms\HttpApi\Acl;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\GetDynamicApiValue;
use Zrcms\HttpApi\HttpApiDynamic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedDynamic implements HttpApiDynamic
{
    const SOURCE = 'http-api-is-allowed-dynamic';

    protected $serviceContainer;
    protected $getRouteOptions;
    protected $getDynamicApiValue;
    protected $isAllowedDefault;

    protected $name;
    protected $notAllowedStatusDefault;
    protected $debug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param GetRouteOptions    $getRouteOptions
     * @param GetDynamicApiValue $getDynamicApiValue
     * @param int                $notAllowedStatusDefault
     * @param bool               $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetRouteOptions $getRouteOptions,
        GetDynamicApiValue $getDynamicApiValue,
        int $notAllowedStatusDefault = 401,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getRouteOptions = $getRouteOptions;
        $this->getDynamicApiValue = $getDynamicApiValue;
        $this->notAllowedStatusDefault = $notAllowedStatusDefault;
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

        $isAllowedConfig = $this->getDynamicApiValue->__invoke(
            $zrcmsImplementation,
            $zrcmsApiName,
            static::MIDDLEWARE_NAME_ACL,
            []
        );

        $isAllowedServiceName = Param::getString(
            $isAllowedConfig,
            'isAllowed'
        );

        $isAllowed = $this->serviceContainer->get($isAllowedServiceName);

        if (!$isAllowed instanceof IsAllowed) {
            throw new \Exception('IsAllowed must be instance of ' . IsAllowed::class);
        }

        $isAllowedOptions = Param::getArray(
            $isAllowedConfig,
            'isAllowedOptions',
            []
        );

        $allowed = $isAllowed->__invoke(
            $request,
            $isAllowedOptions
        );

        if (!$allowed) {
            $notAllowedStatus = Param::getInt(
                $isAllowedConfig,
                'notAllowedStatus',
                $this->notAllowedStatusDefault
            );

            $apiMessages = [
                'type' => $zrcmsImplementation . ':' . $zrcmsApiName,
                'value' => 'Not Allowed',
                'source' => self::SOURCE,
                'code' => $notAllowedStatus,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $notAllowedStatus
            );
        }

        return $next($request, $response);
    }
}
