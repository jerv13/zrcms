<?php

namespace Zrcms\HttpAssetsApplicationState\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Stdlib\ResponseInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ApplicationState
{
    protected $getApplicationState;

    /**
     * @param GetApplicationState $getApplicationState
     */
    public function __construct(
        GetApplicationState $getApplicationState
    ) {
        $this->getApplicationState = $getApplicationState;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ZrcmsJsonResponse
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        return new ZrcmsJsonResponse(
            $this->getApplicationState->__invoke($request)
        );
    }
}
