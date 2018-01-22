<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\Http\Model\HttpLimit;
use Zrcms\Http\Model\HttpOffset;
use Zrcms\Http\Model\HttpOrderBy;
use Zrcms\Http\Model\HttpWhere;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\GetDynamicApiValue;
use Zrcms\HttpApi\HttpApiDynamic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourcesByDynamic implements HttpApiDynamic
{
    const SOURCE = 'http-api-find-cms-resources-by-dynamic';

    protected $serviceContainer;
    protected $getRouteOptions;
    protected $getDynamicApiValue;
    protected $cmsResourcesToArrayDefault;
    protected $debug;

    /**
     * @param ContainerInterface  $serviceContainer
     * @param GetRouteOptions     $getRouteOptions
     * @param GetDynamicApiValue  $getDynamicApiValue
     * @param CmsResourcesToArray $cmsResourcesToArrayDefault
     * @param bool                $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetRouteOptions $getRouteOptions,
        GetDynamicApiValue $getDynamicApiValue,
        CmsResourcesToArray $cmsResourcesToArrayDefault,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getRouteOptions = $getRouteOptions;
        $this->getDynamicApiValue = $getDynamicApiValue;
        $this->cmsResourcesToArrayDefault = $cmsResourcesToArrayDefault;
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

        $apiConfig = $this->getDynamicApiValue->__invoke(
            $zrcmsImplementation,
            $zrcmsApiName,
            static::MIDDLEWARE_NAME_API,
            []
        );

        $apiServiceName = Param::getString(
            $apiConfig,
            'api-service',
            null
        );

        if ($apiServiceName === null) {
            throw new \Exception('api-service must be defined');
        }

        /** @var FindCmsResourcesBy $apiService */
        $apiService = $this->serviceContainer->get($apiServiceName);

        if (!$apiService instanceof FindCmsResourcesBy) {
            throw new \Exception('api-service must be instance of ' . FindCmsResourcesBy::class);
        }

        $criteria = $request->getAttribute(HttpWhere::ATTRIBUTE, []);
        $orderBy = $request->getAttribute(HttpOrderBy::ATTRIBUTE);
        $limit = $request->getAttribute(HttpLimit::ATTRIBUTE);
        $offset = $request->getAttribute(HttpOffset::ATTRIBUTE);

        $cmsResources = $apiService->__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );

        $toArrayService = $this->cmsResourcesToArrayDefault;

        $toArrayServiceName = Param::getString(
            $apiConfig,
            'to-array',
            null
        );

        if ($toArrayServiceName !== null) {
            /** @var CmsResourceToArray $toArrayService */
            $toArrayService = $this->serviceContainer->get($toArrayServiceName);
        }

        if (!$toArrayService instanceof CmsResourcesToArray) {
            throw new \Exception(
                'to-array must be instance of ' . CmsResourcesToArray::class
                . ' got .' . get_class($toArrayService)
                . ' for implementation: (' . $zrcmsImplementation . ')'
                . ' and api: ' . $zrcmsApiName . ')'
            );
        }

        return new ZrcmsJsonResponse(
            $toArrayService->__invoke($cmsResources),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
