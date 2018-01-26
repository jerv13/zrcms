<?php

namespace Zrcms\HttpApi\ZrcmsConfig;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiZrcmsRoutes
{
    protected $appConfig;

    /**
     * @param array $appConfig
     */
    public function __construct(
        array $appConfig
    ) {
        $this->appConfig = $appConfig;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $routeConfig = $this->appConfig['routes'];

        $routeConfig = array_filter(
            $routeConfig,
            [$this, 'filterRoutes'],
            ARRAY_FILTER_USE_BOTH
        );

        ksort($routeConfig);

        return new ZrcmsJsonResponse(
            $routeConfig,
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }

    /**
     * @param array $routeData
     * @param mixed $key
     *
     * @return bool
     */
    protected function filterRoutes($routeData, $key)
    {
        $name = $this->buildRouteName(
            $key,
            $routeData
        );

        return (substr($name, 0, 6) === "zrcms.");
    }

    /**
     * @param mixed $key
     * @param array $routeData
     *
     * @return null|string
     */
    protected function buildRouteName(
        $key,
        array $routeData
    ) {
        return Param::getString(
            $routeData,
            'name',
            $key
        );
    }
}
