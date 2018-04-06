<?php

namespace Zrcms\HttpApi\CmsResourceHistory;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoriesToArray;
use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistoryBy;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Model\HttpLimit;
use Zrcms\Http\Model\HttpOffset;
use Zrcms\Http\Model\HttpOrderBy;
use Zrcms\Http\Model\HttpWhere;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceHistoryByDynamic implements MiddlewareInterface
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
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|ZrcmsJsonResponse
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $dynamicApiConfig = $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_CONFIG);

        $apiConfig = Property::getArray(
            $dynamicApiConfig,
            Dynamic::MIDDLEWARE_NAME_API,
            []
        );

        $apiServiceName = Property::getString(
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

        $toArrayServiceName = Property::getString(
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
