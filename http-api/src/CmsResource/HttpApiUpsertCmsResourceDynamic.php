<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Model\CmsResourceBasic;
use Zrcms\Core\Model\ContentVersionBasic;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\GetDynamicApiValue;
use Zrcms\HttpApi\HttpApiDynamic;
use Zrcms\Param\Param;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiUpsertCmsResourceDynamic implements HttpApiDynamic
{
    const SOURCE = 'http-api-find-cms-resource-dynamic';

    protected $serviceContainer;
    protected $getRouteOptions;
    protected $getDynamicApiValue;
    protected $getUserIdByRequest;
    protected $cmsResourceToArrayDefault;
    protected $debug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param GetRouteOptions    $getRouteOptions
     * @param GetDynamicApiValue $getDynamicApiValue
     * @param GetUserIdByRequest $getUserIdByRequest
     * @param CmsResourceToArray $cmsResourceToArrayDefault
     * @param bool               $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetRouteOptions $getRouteOptions,
        GetDynamicApiValue $getDynamicApiValue,
        GetUserIdByRequest $getUserIdByRequest,
        CmsResourceToArray $cmsResourceToArrayDefault,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getRouteOptions = $getRouteOptions;
        $this->getDynamicApiValue = $getDynamicApiValue;
        $this->getUserIdByRequest = $getUserIdByRequest;
        $this->cmsResourceToArrayDefault = $cmsResourceToArrayDefault;
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

        /** @var UpsertCmsResource $apiService */
        $apiService = $this->serviceContainer->get($apiServiceName);

        if (!$apiService instanceof UpsertCmsResource) {
            throw new \Exception('api-service must be instance of ' . UpsertCmsResource::class);
        }

        $data = $request->getParsedBody();
        $contentVersionData = $data['contentVersion'];

        $userId = $this->getUserIdByRequest->__invoke($request);

        $contentVersion = new ContentVersionBasic(
            $contentVersionData['id'],
            $contentVersionData['properties'],
            $userId,
            $contentVersionData['createdReason']
        );

        $newCmsResource = new CmsResourceBasic(
            $data['id'],
            $data['published'],
            $contentVersion,
            $userId,
            $contentVersionData['createdReason']
        );

        $cmsResource = $apiService->__invoke(
            $newCmsResource,
            $userId,
            $contentVersionData['createdReason']
        );

        $toArrayService = $this->cmsResourceToArrayDefault;

        $toArrayServiceName = Param::getString(
            $apiConfig,
            'to-array',
            null
        );

        if ($toArrayServiceName !== null) {
            /** @var CmsResourceToArray $isAllowed */
            $toArrayService = $this->serviceContainer->get($toArrayServiceName);
        }

        if (!$toArrayService instanceof CmsResourceToArray) {
            throw new \Exception(
                'to-array must be instance of ' . CmsResourceToArray::class
                . ' got .' . get_class($toArrayService)
                . ' for implementation: (' . $zrcmsImplementation . ')'
                . ' and api: ' . $zrcmsApiName . ')'
            );
        }

        return new ZrcmsJsonResponse(
            $toArrayService->__invoke($cmsResource)
        );
    }
}
