<?php

namespace Zrcms\HttpApi\Content;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\Content\InsertContentVersion;
use Zrcms\Core\Model\ContentVersionBasic;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiInsertContentVersionDynamic implements MiddlewareInterface
{
    const SOURCE = 'http-api-insert-content-version-dynamic';

    protected $serviceContainer;
    protected $getUserIdByRequest;
    protected $contentVersionToArrayDefault;
    protected $debug;

    /**
     * @param ContainerInterface    $serviceContainer
     * @param GetUserIdByRequest    $getUserIdByRequest
     * @param ContentVersionToArray $contentVersionToArrayDefault
     * @param bool                  $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetUserIdByRequest $getUserIdByRequest,
        ContentVersionToArray $contentVersionToArrayDefault,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getUserIdByRequest = $getUserIdByRequest;
        $this->contentVersionToArrayDefault = $contentVersionToArrayDefault;
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

        /** @var InsertContentVersion $apiService */
        $apiService = $this->serviceContainer->get($apiServiceName);

        if (!$apiService instanceof InsertContentVersion) {
            throw new \Exception('api-service must be instance of ' . InsertContentVersion::class);
        }

        $contentVersionData = $request->getParsedBody();

        $reason = $contentVersionData['createdReason'] . ' (source: ' . static::SOURCE . ')';

        $userId = $this->getUserIdByRequest->__invoke($request);

        $contentVersion = new ContentVersionBasic(
            null,
            $contentVersionData['properties'],
            $userId,
            $reason
        );

        $contentVersion = $apiService->__invoke(
            $contentVersion
        );

        $toArrayService = $this->contentVersionToArrayDefault;

        $toArrayServiceName = Property::getString(
            $apiConfig,
            'to-array',
            null
        );

        if ($toArrayServiceName !== null) {
            /** @var ContentVersionToArray $isAllowed */
            $toArrayService = $this->serviceContainer->get($toArrayServiceName);
        }

        if (!$toArrayService instanceof ContentVersionToArray) {
            throw new \Exception(
                'to-array must be instance of ' . ContentVersionToArray::class
                . ' got .' . get_class($toArrayService)
                . ' for dynamic api: (' . $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE) . ')'
            );
        }

        return new ZrcmsJsonResponse(
            $toArrayService->__invoke($contentVersion),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
