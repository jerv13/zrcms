<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\Core\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\Http\Api\GetRouteOptions;
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
    protected $notFoundStatusDefault;
    protected $debug;

    /**
     * @param ContainerInterface  $serviceContainer
     * @param GetRouteOptions     $getRouteOptions
     * @param GetDynamicApiValue  $getDynamicApiValue
     * @param CmsResourcesToArray $cmsResourcesToArrayDefault
     * @param int                 $notFoundStatusDefault
     * @param bool                $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetRouteOptions $getRouteOptions,
        GetDynamicApiValue $getDynamicApiValue,
        CmsResourcesToArray $cmsResourcesToArrayDefault,
        int $notFoundStatusDefault = 404,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getRouteOptions = $getRouteOptions;
        $this->getDynamicApiValue = $getDynamicApiValue;
        $this->cmsResourcesToArrayDefault = $cmsResourcesToArrayDefault;
        $this->notFoundStatusDefault = $notFoundStatusDefault;
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
            'apiService',
            null
        );

        if ($apiServiceName === null) {
            throw new \Exception('apiService must be defined');
        }

        /** @var FindCmsResourcesBy $apiService */
        $apiService = $this->serviceContainer->get($apiServiceName);

        if (!$apiService instanceof FindCmsResourcesBy) {
            throw new \Exception('ApiService must be instance of ' . FindCmsResourcesBy::class);
        }

        $cmsResources = $apiService->__invoke($id, []);


        $toArrayService = $this->cmsResourcesToArrayDefault;

        $toArrayServiceName = Param::getString(
            $apiConfig,
            'toArray',
            null
        );

        if ($toArrayServiceName !== null) {
            /** @var CmsResourceToArray $isAllowed */
            $toArrayService = $this->serviceContainer->get($toArrayServiceName);
        }

        if (!$toArrayService instanceof CmsResourceToArray) {
            throw new \Exception('toArray must be instance of ' . CmsResourceToArray::class);
        }

        return new ZrcmsJsonResponse(
            $toArrayService->__invoke($cmsResource)
        );
    }
}
