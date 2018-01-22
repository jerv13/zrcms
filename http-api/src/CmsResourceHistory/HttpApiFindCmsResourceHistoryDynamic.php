<?php

namespace Zrcms\HttpApi\CmsResourceHistory;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistory;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\GetDynamicApiValue;
use Zrcms\HttpApi\HttpApiDynamic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceHistoryDynamic implements HttpApiDynamic
{
    const SOURCE = 'http-api-find-cms-resource-history-dynamic';

    protected $serviceContainer;
    protected $getRouteOptions;
    protected $getDynamicApiValue;
    protected $cmsResourceHistoryToArrayDefault;
    protected $notFoundStatusDefault;
    protected $debug;

    /**
     * @param ContainerInterface        $serviceContainer
     * @param GetRouteOptions           $getRouteOptions
     * @param GetDynamicApiValue        $getDynamicApiValue
     * @param CmsResourceHistoryToArray $cmsResourceHistoryToArrayDefault
     * @param int                       $notFoundStatusDefault
     * @param bool                      $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetRouteOptions $getRouteOptions,
        GetDynamicApiValue $getDynamicApiValue,
        CmsResourceHistoryToArray $cmsResourceHistoryToArrayDefault,
        int $notFoundStatusDefault = 404,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getRouteOptions = $getRouteOptions;
        $this->getDynamicApiValue = $getDynamicApiValue;
        $this->cmsResourceHistoryToArrayDefault = $cmsResourceHistoryToArrayDefault;
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
            'api-service',
            null
        );

        if ($apiServiceName === null) {
            throw new \Exception('api-service must be defined');
        }

        /** @var FindCmsResourceHistory $apiService */
        $apiService = $this->serviceContainer->get($apiServiceName);

        if (!$apiService instanceof FindCmsResourceHistory) {
            throw new \Exception('api-service must be instance of ' . FindCmsResourceHistory::class);
        }

        $id = $request->getAttribute(static::ATTRIBUTE_ZRCMS_ID);

        $cmsResourceHistory = $apiService->__invoke($id, []);

        if (empty($cmsResourceHistory)) {
            $notFoundStatus = Param::getInt(
                $apiConfig,
                'not-found-status',
                $this->notFoundStatusDefault
            );

            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$notFoundStatus,
                    'Not Found with id: ' . $id,
                    $zrcmsImplementation . ':' . $zrcmsApiName,
                    self::SOURCE
                ),
                $notFoundStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        $toArrayService = $this->cmsResourceHistoryToArrayDefault;

        $toArrayServiceName = Param::getString(
            $apiConfig,
            'to-array',
            null
        );

        if ($toArrayServiceName !== null) {
            /** @var CmsResourceHistoryToArray $isAllowed */
            $toArrayService = $this->serviceContainer->get($toArrayServiceName);
        }

        if (!$toArrayService instanceof CmsResourceHistoryToArray) {
            throw new \Exception(
                'to-array must be instance of ' . CmsResourceHistoryToArray::class
                . ' got .' . get_class($toArrayService)
                . ' for implementation: (' . $zrcmsImplementation . ')'
                . ' and api: ' . $zrcmsApiName . ')'
            );
        }

        return new ZrcmsJsonResponse(
            $toArrayService->__invoke($cmsResourceHistory),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
