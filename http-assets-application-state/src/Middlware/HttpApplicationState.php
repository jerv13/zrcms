<?php

namespace Zrcms\HttpAssetsApplicationState\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApplicationState
{
    const PARAM_APPLICATION_STATE = 'application-state';

    protected $getApplicationState;
    protected $debug;

    /**
     * @param GetApplicationState $getApplicationState
     * @param bool                $debug
     */
    public function __construct(
        GetApplicationState $getApplicationState,
        bool $debug = false
    ) {
        $this->getApplicationState = $getApplicationState;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return JsonResponse
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $params = $request->getQueryParams();
        $returnAppState = Param::getBool(
            $params,
            static::PARAM_APPLICATION_STATE,
            false
        );

        if ($returnAppState) {
            return new JsonResponse(
                $this->getApplicationState->__invoke($request),
                200,
                [],
                ($this->debug ? JSON_PRETTY_PRINT : 0)
            );
        }

        return $next($request, $response);
    }
}
