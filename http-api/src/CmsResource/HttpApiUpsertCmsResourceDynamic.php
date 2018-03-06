<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Reliv\ValidationRat\Model\ValidationResultBasic;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Core\Model\CmsResourceBasic;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiUpsertCmsResourceDynamic
{
    const SOURCE = 'http-api-find-cms-resource-dynamic';

    protected $serviceContainer;
    protected $getUserIdByRequest;
    protected $cmsResourceToArrayDefault;
    protected $debug;

    /**
     * @param ContainerInterface $serviceContainer
     * @param GetUserIdByRequest $getUserIdByRequest
     * @param CmsResourceToArray $cmsResourceToArrayDefault
     * @param bool               $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetUserIdByRequest $getUserIdByRequest,
        CmsResourceToArray $cmsResourceToArrayDefault,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
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
        $dynamicApiConfig = $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_CONFIG);

        $apiConfig = Property::getArray(
            $dynamicApiConfig,
            Dynamic::MIDDLEWARE_NAME_API,
            []
        );

        $apiServiceUpsertCmsResource = $this->getUpsertApiService(
            $apiConfig
        );

        $apiServiceFindVersion = $this->getFindContentVersionApiService(
            $apiConfig
        );

        $data = $request->getParsedBody();

        $contentVersionId = $data['contentVersionId'];

        $contentVersion = $apiServiceFindVersion->__invoke(
            $contentVersionId
        );

        $reason = $data['createdReason'] . ' (source: ' . static::SOURCE . ')';

        $userId = $this->getUserIdByRequest->__invoke($request);

        $cmsResource = $apiServiceUpsertCmsResource->__invoke(
            $data['id'],
            $data['published'],
            $contentVersionId,
            $userId,
            $reason
        );

        $toArrayService = $this->cmsResourceToArrayDefault;

        $toArrayServiceName = Property::getString(
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
                . ' for dynamic api: (' . $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE) . ')'
            );
        }

        return new ZrcmsJsonResponse(
            $toArrayService->__invoke($cmsResource),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }

    /**
     * @param array $apiConfig
     *
     * @return FindContentVersion
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getFindContentVersionApiService(
        array $apiConfig
    ): FindContentVersion {
        $apiServiceNameFindVersion = Property::getString(
            $apiConfig,
            'api-service-find-content-version',
            null
        );

        if (empty($apiServiceNameFindVersion)) {
            throw new \Exception('api-service-find-content-version must be defined');
        }

        /** @var FindContentVersion $apiServiceFindVersion */
        $apiServiceFindVersion = $this->serviceContainer->get($apiServiceNameFindVersion);

        if (!$apiServiceFindVersion instanceof FindContentVersion) {
            throw new \Exception(
                'api-service-find-content-version must be instance of ' . FindContentVersion::class
            );
        }

        return $apiServiceFindVersion;
    }

    /**
     * @param array $apiConfig
     *
     * @return UpsertCmsResource
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getUpsertApiService(
        array $apiConfig
    ): UpsertCmsResource {
        $apiServiceName = Property::getString(
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
            throw new \Exception(
                'api-service must be instance of ' . UpsertCmsResource::class
            );
        }

        return $apiService;
    }
}
