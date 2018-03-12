<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\CreateCmsResource;
use Zrcms\Core\Exception\CmsResourceExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiCreateCmsResourceDynamic
{
    const SOURCE = 'http-api-create-cms-resource-dynamic';

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

        $apiServiceCreateCmsResource = $this->getCreateApiService(
            $apiConfig
        );

        $data = $request->getParsedBody();

        $reason = $data['createdReason'] . ' (source: ' . static::SOURCE . ')';

        $userId = $this->getUserIdByRequest->__invoke($request);

        try {
            $cmsResource = $apiServiceCreateCmsResource->__invoke(
                $data['id'],
                $data['published'],
                $data['contentVersionId'],
                $userId,
                $reason
            );
        } catch (CmsResourceExists $exception) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    'cms-resource-already-exists',
                    'CMS Resource already exists with ID: (' . $data['id'] . ')',
                    $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE),
                    self::SOURCE
                ),
                400,
                [],
                BuildResponseOptions::invoke()
            );
        } catch (ContentVersionNotExists $exception) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    'content-version-already-exists',
                    'Content Version already exists with ID: (' . $data['id'] . ')',
                    $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE),
                    self::SOURCE
                ),
                400,
                [],
                BuildResponseOptions::invoke()
            );
        }

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
     * @return CreateCmsResource
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getCreateApiService(
        array $apiConfig
    ): CreateCmsResource {
        $apiServiceName = Property::getString(
            $apiConfig,
            'api-service',
            null
        );

        if ($apiServiceName === null) {
            throw new \Exception('api-service must be defined');
        }
        /** @var CreateCmsResource $apiService */
        $apiService = $this->serviceContainer->get($apiServiceName);

        if (!$apiService instanceof CreateCmsResource) {
            throw new \Exception(
                'api-service must be instance of ' . CreateCmsResource::class
            );
        }

        return $apiService;
    }
}
