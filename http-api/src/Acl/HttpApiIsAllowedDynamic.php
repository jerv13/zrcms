<?php

namespace Zrcms\HttpApi\Acl;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedDynamic
{
    const SOURCE = 'http-api-is-allowed-dynamic';

    protected $serviceContainer;
    protected $isAllowedDefault;

    protected $name;
    protected $notAllowedStatusDefault;
    protected $debug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param int                $notAllowedStatusDefault
     * @param bool               $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        int $notAllowedStatusDefault = 401,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
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
        $dynamicApiConfig = $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_CONFIG);

        $isAllowedConfig = Property::getArray(
            $dynamicApiConfig,
            Dynamic::MIDDLEWARE_NAME_ACL,
            []
        );

        $isAllowedServiceName = Property::getString(
            $isAllowedConfig,
            'is-allowed'
        );

        if (!$this->serviceContainer->has($isAllowedServiceName)) {
            throw new \Exception(
                'is-allowed must be a service: (' . $isAllowedServiceName . ')'
            );
        }

        $isAllowed = $this->serviceContainer->get($isAllowedServiceName);

        if (!$isAllowed instanceof IsAllowed) {
            throw new \Exception(
                'IsAllowed must be instance of ' . IsAllowed::class
                . ' got (' . get_class($isAllowed) . ')'
                . ' for dynamic api: (' . $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE) . ')'
            );
        }

        $isAllowedOptions = Property::getArray(
            $isAllowedConfig,
            'is-allowed-options',
            []
        );

        $allowed = $isAllowed->__invoke(
            $request,
            $isAllowedOptions
        );

        if (!$allowed) {
            $notAllowedStatus = Property::getInt(
                $isAllowedConfig,
                'not-allowed-status',
                $this->notAllowedStatusDefault
            );

            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$notAllowedStatus,
                    'Not Allowed',
                    $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE),
                    self::SOURCE
                ),
                $notAllowedStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        return $next($request, $response);
    }
}
