<?php

namespace Zrcms\HttpApi\CmsResourceHistory;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoriesToArray;
use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistoryBy;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Model\HttpLimit;
use Zrcms\Http\Model\HttpOffset;
use Zrcms\Http\Model\HttpOrderBy;
use Zrcms\Http\Model\HttpWhere;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceHistoryByDynamic
{
    const SOURCE = 'http-api-find-cms-resource-history-by-dynamic';

    protected $serviceContainer;
    protected $cmsResourceHistoriesToArrayDefault;
    protected $debug;

    /**
     * @param ContainerInterface          $serviceContainer
     * @param CmsResourceHistoriesToArray $cmsResourceHistoriesToArrayDefault
     * @param bool                        $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        CmsResourceHistoriesToArray $cmsResourceHistoriesToArrayDefault,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->cmsResourceHistoriesToArrayDefault = $cmsResourceHistoriesToArrayDefault;
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

        $apiConfig = Param::getArray(
            $dynamicApiConfig,
            Dynamic::MIDDLEWARE_NAME_API,
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

        /** @var FindCmsResourceHistoryBy $apiService */
        $apiService = $this->serviceContainer->get($apiServiceName);

        if (!$apiService instanceof FindCmsResourceHistoryBy) {
            throw new \Exception('api-service must be instance of ' . FindCmsResourceHistoryBy::class);
        }

        $criteria = $request->getAttribute(HttpWhere::ATTRIBUTE, []);
        $orderBy = $request->getAttribute(HttpOrderBy::ATTRIBUTE);
        $limit = $request->getAttribute(HttpLimit::ATTRIBUTE);
        $offset = $request->getAttribute(HttpOffset::ATTRIBUTE);

        $cmsResourceHistories = $apiService->__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );

        $toArrayService = $this->cmsResourceHistoriesToArrayDefault;

        $toArrayServiceName = Param::getString(
            $apiConfig,
            'to-array',
            null
        );

        if ($toArrayServiceName !== null) {
            /** @var CmsResourceHistoriesToArray $toArrayService */
            $toArrayService = $this->serviceContainer->get($toArrayServiceName);
        }

        if (!$toArrayService instanceof CmsResourceHistoriesToArray) {
            throw new \Exception(
                'to-array must be instance of ' . CmsResourceHistoriesToArray::class
                . ' got .' . get_class($toArrayService)
                . ' for dynamic api: (' . $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE) . ')'
            );
        }

        return new ZrcmsJsonResponse(
            $toArrayService->__invoke($cmsResourceHistories),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
