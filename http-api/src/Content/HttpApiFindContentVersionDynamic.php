<?php

namespace Zrcms\HttpApi\Content;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpApi\Dynamic;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindContentVersionDynamic
{
    const SOURCE = 'http-api-find-content-version-dynamic';

    protected $serviceContainer;
    protected $contentVersionToArrayDefault;
    protected $notFoundStatusDefault;
    protected $debug;

    /**
     * @param ContainerInterface    $serviceContainer
     * @param ContentVersionToArray $contentVersionToArrayDefault
     * @param int                   $notFoundStatusDefault
     * @param bool                  $debug
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        ContentVersionToArray $contentVersionToArrayDefault,
        int $notFoundStatusDefault = 404,
        bool $debug = false
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->contentVersionToArrayDefault = $contentVersionToArrayDefault;
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

        /** @var FindContentVersion $apiService */
        $apiService = $this->serviceContainer->get($apiServiceName);

        if (!$apiService instanceof FindContentVersion) {
            throw new \Exception('api-service must be instance of ' . FindContentVersion::class);
        }

        $id = $request->getAttribute(Dynamic::ATTRIBUTE_ZRCMS_ID);

        $contentVersion = $apiService->__invoke($id, []);

        if (empty($contentVersion)) {
            $notFoundStatus = Property::getInt(
                $apiConfig,
                'not-found-status',
                $this->notFoundStatusDefault
            );

            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$notFoundStatus,
                    'Not Found with id: ' . $id,
                    $request->getAttribute(Dynamic::ATTRIBUTE_DYNAMIC_API_TYPE),
                    self::SOURCE
                ),
                $notFoundStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

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
