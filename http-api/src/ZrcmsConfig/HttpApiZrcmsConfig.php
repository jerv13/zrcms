<?php

namespace Zrcms\HttpApi\ZrcmsConfig;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiZrcmsConfig
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
        $zrcmsConfig = array_filter(
            $this->appConfig,
            function ($value, $key) {
                return (substr($key, 0, 6) === "zrcms-");
            },
            ARRAY_FILTER_USE_BOTH
        );

        return new ZrcmsJsonResponse(
            $zrcmsConfig,
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
