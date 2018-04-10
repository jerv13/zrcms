<?php

namespace Zrcms\HttpApi\ZrcmsConfig;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiZrcmsConfig implements MiddlewareInterface
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
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|ZrcmsJsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $zrcmsConfig = array_filter(
            $this->appConfig,
            function ($value, $key) {
                return (substr($key, 0, 6) === "zrcms-");
            },
            ARRAY_FILTER_USE_BOTH
        );

        ksort($zrcmsConfig);

        return new ZrcmsJsonResponse(
            $zrcmsConfig,
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
